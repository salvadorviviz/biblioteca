<table class="table table-striped">
    <thead>
        <tr>
            <th>Portada</th>
            <th>Título</th>
            <th>Saga</th>
            <th>Género</th>
            <th class="text-center">
                @php
                    $nextSort = getNextSort('rating');
                @endphp
                <a class="enlace" href="{{ route('books.index', ['sort' => $nextSort['sort'], 'direction' => $nextSort['direction']]) }}">
                    Nota 
                    @if(request('sort') == 'rating')
                        @if(request('direction') == 'asc')
                            🔼
                        @else
                            🔽
                        @endif
                    @endif
                </a>
            </th>                    
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>
                @if($book->cover)
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Portada" width="50"
                         class="img-thumbnail open-modal" data-bs-toggle="modal"
                         data-bs-target="#imageModal" data-title="{{ $book->title }}" 
                         data-image="{{ asset('storage/' . $book->cover) }}">
                @else
                    No disponible
                @endif
            </td>                                       
            <td>{{ $book->title }}</td>
            <td>{{ $book->saga ?? '' }}</td>
            <td>{{ $book->genre }}</td>
            <td class="text-center">
                @if (!is_null($book->rating))
                    <span class="fw-bold" style="color: {{ getRatingColor($book->rating) }};">
                        <i class="bi bi-star-fill"></i> {{ $book->rating }}
                    </span>
                @endif
            </td>                                    
            <td>
                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                    <i class="bi bi-pencil-fill"></i>
                </a>
                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline form-delete">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm"  data-bs-toggle="tooltip" data-bs-placement="top" title="Borrar">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>           
</table>
<!-- Modal único para todas las imágenes -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header">
                <button class="modal-title btn btn-dark btn-lg btn-block" style="width: 100% !important" id="modalTitle" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Portada" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>      
<!-- Bottom de la tabla -->
<div class="row align-items-center mt-3 text-muted text-center">
    <div class="col-md-4 d-flex justify-content-center align-items-center gap-2 space-bottom-table">
        <form id="perPageForm" class="d-flex align-items-center gap-2 form-delete">
            <select name="perPage" id="perPage" class="form-select form-select-sm w-auto">
                <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                <option value="30" {{ request('perPage') == 30 ? 'selected' : '' }}>30</option>
            </select>
            <span>por página</span>
        </form>
    </div>
    <div class="col-md-4 d-flex justify-content-center align-items-center gap-2">
        {{ $books->links() }}
    </div>
    <div class="col-md-4 d-flex justify-content-center align-items-center gap-2 space-bottom-table">
        @if ($books->total() > 0)
            Mostrando {{ $books->firstItem() }} - {{ $books->lastItem() }} de {{ $books->total() }} libros
        @else
            Sin resultados
        @endif
    </div>
</div> 