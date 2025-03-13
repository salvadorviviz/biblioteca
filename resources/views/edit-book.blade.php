@extends('layouts.app')
@section('title', 'Editar libro')
@section('content')
    <h1 class="mb-4">📚 Editar libro</h1>
    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $book->title }}" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Género</label>
            <!-- Select con búsqueda en vivo -->
            <select name="genre" id="genre" class="selectpicker w-100" data-live-search="true">
                <option value="">Selecciona un género</option>
                <option value="other">Otro (Escribir nuevo)</option>
                @foreach($genres as $g)
                    <option value="{{ $g }}" {{ $book->genre == $g ? 'selected' : '' }}>{{ $g }}</option>
                @endforeach
            </select>
            <!-- Input de texto oculto para escribir un nuevo género -->
            <input type="text" name="newGenre" id="newGenre" class="form-control mt-2" placeholder="Escribe un nuevo género" style="display: none;">
        </div> 
        <div class="mb-3">
            <label for="saga" class="form-label">Saga</label>
            <select name="saga" id="saga" class="selectpicker w-100" data-live-search="true">
                <option value="">Selecciona una saga</option>
                <option value="other">Otra (Escribir nueva)</option>
                @foreach($sagas as $s)
                    <option value="{{ $s }}" {{ $book->saga == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            <input type="text" name="newSaga" id="newSaga" class="form-control mt-2" placeholder="Escribe una nueva saga" 
                   style="display: none;">
        </div>        
        <div class="mb-3">
            <label for="rating" class="form-label">Puntuación (0-5)</label>
            <input type="number" name="rating" id="rating" class="form-control" value="{{ $book->rating }}" min="0" max="5">
        </div>
        <div class="mb-3">
            <label for="cover" class="form-label">Portada (dejar en blanco para no cambiar)</label>
            <input type="file" name="cover" id="cover" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancelar y volver</a>
    </form>
    <div class="toast-container position-fixed top-0 end-0 p-3">
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
            $('#saga').on('change', function () {
                let selectedValue = $(this).val();
                if (selectedValue === "other") {
                    $('#newSaga').show().focus();
                } else {
                    $('#newSaga').hide().val('');
                }
            });

            // Obtener saga correctamente sin problemas de escape
            let sagaValue = @json($book->saga);

            // Si el usuario ya tenía una saga que no está en la lista, mostrar el input
            if (!$('#saga option[value="' + sagaValue + '"]').length && sagaValue !== "") {
                $('#saga').val("other").selectpicker('refresh');
                $('#newSaga').val(sagaValue).show();
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            var toastError = document.getElementById("toastError");
            var toastValidation = document.getElementById("toastValidation");
            if (toastError) {
                new bootstrap.Toast(toastError, { delay: 5000 }).show(); // Se oculta en 5 segundos
            }
            if (toastValidation) {
                new bootstrap.Toast(toastValidation, { delay: 7000 }).show(); // Se oculta en 7 segundos
            }
        });
    </script>    
@endsection