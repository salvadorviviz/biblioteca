@extends('layouts.app')
@section('title', 'Biblioteca')
@section('content')
        <h2 class="mb-4 d-flex align-items-center" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#addBookForm" aria-expanded="false" aria-controls="addBookForm">
            📚 Añadir libro
        </h2>
        <!-- Formulario de añadir libros -->
        <div class="collapse" id="addBookForm">
            <div class="card card-body form_add">
                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rating" class="form-label">Puntuación (0-5)</label>
                            <input type="number" name="rating" id="rating" class="form-control" min="0" max="5">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="genre" class="form-label">Género</label>
                            <!-- Select con búsqueda en vivo -->
                            <select name="genre" id="genre" class="selectpicker w-100" data-live-search="true">
                                <option value="">Selecciona un género</option>
                                <option value="other">Otro (Escribir nuevo)</option>
                                @foreach($genres as $g)
                                    <option value="{{ $g }}">{{ $g }}</option>
                                @endforeach
                            </select>
                            <!-- Input de texto oculto para escribir un nuevo género -->
                            <input type="text" name="newGenre" id="newGenre" class="form-control mt-2" placeholder="Escribe un nuevo género" style="display: none;">
                        </div> 
                        <div class="col-md-6">
                            <label for="saga" class="form-label">Saga</label>
                            <select name="saga" id="saga" class="selectpicker w-100" data-live-search="true">
                                <option value="">Selecciona una saga</option>
                                <option value="other">Otra (Escribir nueva)</option>
                                @foreach($sagas as $s)
                                    <option value="{{ $s }}">{{ $s }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="newSaga" id="newSaga" class="form-control mt-2" placeholder="Escribe una nueva saga" style="display: none;">
                        </div>                                                    
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="cover" class="form-label">Portada</label>
                            <input type="file" name="cover" id="cover" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-dark">Añadir libro</button>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <!-- Sección de filtros -->
        <h2 class="mt-4">📖 Biblioteca</h2>
        <form id="filter-form" class="mb-4">
            @csrf <!-- Token CSRF para proteger la solicitud POST -->
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="title" class="form-label">Buscar por título</label>
                    <input type="text" name="title" id="title" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="genre" class="form-label">Filtrar por género</label>
                    <select name="genre" id="genre" class="selectpicker w-100" data-live-search="true">
                        <option value="">Todos</option>
                        @foreach($genres as $g)
                            <option value="{{ $g }}" {{ request('genre') == $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="rating" class="form-label">Filtrar por nota</label>
                    <select name="rating" id="rating" class="selectpicker w-100">
                        <option value="">Todas</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                        <option value="null" {{ request('rating') === 'null' ? 'selected' : '' }}>Sin leer</option>
                    </select>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary" id="filter-submit">Filtrar</button>
                <button type="button" onclick="window.location='{{ route('books.index') }}'" class="btn btn-secondary">Limpiar</button>
                <button type="button" onclick="window.location='{{ route('books.export.csv', request()->query()) }}'" class="btn btn-success">Exportar</button>                 
            </div>
        </form>
        <!-- Tabla de libros -->
        <div id="books-table">
            @include('partials.books-table', ['books' => $books])
        </div>           
    <!-- Mensajes toast -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        @if(session('success'))
            <div id="toastSuccess" class="toast align-items-center text-white bg-success border-0 w-auto" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div id="toastError" class="toast align-items-center text-white bg-danger border-0 w-auto" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div id="toastValidation" class="toast align-items-center text-white bg-warning border-0 w-auto" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>Errores:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>     
    <script>
        $(document).ready(function () { 

            // Modificamos y mostramos la modal de la portada
            function updateModal(img) {
                document.querySelectorAll(".open-modal").forEach(img => {
                    img.addEventListener("click", function() {
                        const title = this.getAttribute("data-title").toUpperCase();
                        const image = this.getAttribute("data-image");

                        document.getElementById("modalTitle").textContent = title;
                        document.getElementById("modalImage").src = image;
                    });
                });
            }
            document.addEventListener("DOMContentLoaded", updateModal());

            // Capturamos el evento de hacer clic en el botón de "Filtrar"
            $('#filter-submit').on('click', function() {
                var filters = $('#filter-form').serialize();
                $.ajax({
                    url: "{{ route('books.tabla') }}", 
                    method: "POST", 
                    data: filters, 
                    success: function(response) {
                        $('#books-table').html(response); 
                        updateModal(this);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });

            // Cantidad por página (ajax)
            $(document).on('change', '#perPage', function() {
                const perPage = $(this).val();
                const filters = $('#filter-form').serialize();

                $.ajax({
                    url: '/books/tabla',
                    method: 'POST',
                    data: filters + '&perPage=' + perPage + '&_token={{ csrf_token() }}',
                    success: function(response) {
                        $('#books-table').html(response);
                        updateModal();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });

            // Paginación de Laravel por Ajax
            $(document).on('click', '#books-table .pagination a', function(e){
                e.preventDefault();

                const page = $(this).attr('href').split('page=')[1];
                const perPage = $('#perPage').val();
                const filters = $('#filter-form').serialize();

                $.ajax({
                    url: '/books/tabla?page=' + page,
                    method: 'POST',
                    data: filters + '&perPage=' + perPage,
                    success: function(response){
                        $('#books-table').html(response);
                        updateModal();
                    },
                    error: function(xhr, status, error){
                        console.log('Error:', error);
                    }
                });
            });

            $('#genre').on('change', function () {
                let selectedValue = $(this).val();
    
                if (selectedValue === "other") {
                    // Si selecciona "Otro", mostrar el input para escribir un nuevo género
                    $('#newGenre').show().focus();
                } else {
                    // Ocultar el input si selecciona un género existente
                    $('#newGenre').hide().val('');
                }
            });
            

            $('#saga').on('change', function () {
                let selectedValue = $(this).val();

                if (selectedValue === "other") {
                    $('#newSaga').show().focus();
                } else {
                    $('#newSaga').hide().val('');
                }
            });

        });

        document.addEventListener("DOMContentLoaded", function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            var toastSuccess = document.getElementById("toastSuccess");
            var toastError = document.getElementById("toastError");
            var toastValidation = document.getElementById("toastValidation");

            if (toastSuccess) {
                new bootstrap.Toast(toastSuccess, { delay: 3000 }).show(); // Se oculta en 3 segundos
            }

            if (toastError) {
                new bootstrap.Toast(toastError, { delay: 5000 }).show(); // Se oculta en 5 segundos
            }

            if (toastValidation) {
                new bootstrap.Toast(toastValidation, { delay: 7000 }).show(); // Se oculta en 7 segundos
            }
        });
    </script>            
@endsection