<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    // Mostrar todos los libros
    public function index(Request $request)
    {
        $genres = Book::select('genre')->distinct()->pluck('genre')->sort();
        $sagas = Book::whereNotNull('saga')->where('saga', '!=', '')->distinct()->pluck('saga')->sort();
        $query = Book::query();

        if ($request->filled('title')) {
            $query->where('title', 'LIKE', '%' . $request->title . '%');
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        if ($request->filled('saga')) {
            $query->where('saga', $request->saga);
        }

        if ($request->filled('rating')) {
            if ($request->rating === 'null') {
                $query->whereNull('rating'); // Filtra libros sin calificación
            } else {
                $query->where('rating', $request->rating);
            }
        }                        

        // Manejar ordenación por puntuación
        $sort = $request->input('sort', 'id'); // Por defecto ordena por ID
        $direction = $request->input('direction', 'asc'); // Por defecto ascendente

        // Aplicar orden si `sort` no es null
        if ($sort !== null) {
            $query->orderBy($sort, $direction);
        }

        // Paginación
        $perPage = $request->input('perPage', 10); // Por defecto, 10 resultados
        $books = $query->paginate($perPage)->appends($request->query());

        // Si es una petición AJAX, devolver solo la tabla
        if ($request->ajax()) {
            return view('partials.books-table', compact('books', 'genres', 'sagas', 'sort', 'direction'));
        }

        return view('books', compact('books', 'genres', 'sagas', 'sort', 'direction'));
    }

    // Guardar un nuevo libro
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'rating' => 'nullable|integer|min:0|max:5',
            'cover' => 'nullable|image|max:2048',
        ]);

        // Si el usuario escribió un nuevo género, usarlo en lugar del seleccionado
        $genre = $request->newGenre ?: $request->genre;
        $saga = $request->newSaga ?: ($request->saga ?: '');

        $book = new Book();
        $book->title = $request->title;
        $book->genre = $genre;
        $book->saga = $saga;
        $book->rating = $request->rating !== null ? $request->rating : null;

        if ($request->hasFile('cover')) {
            $book->cover = $request->file('cover')->store('covers', 'public');
        }

        try {
            $book->save();
            return redirect()->route('books.index')->with('success', 'Libro añadido correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('books.index')->with('error', 'Hubo un problema al añadir el libro.');
        }
    }


    // Mostrar un libro por ID
    public function show($id)
    {
        return response()->json(Book::findOrFail($id));
    }

    // Actualizar un libro por ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'rating' => 'nullable|integer|min:0|max:5',
            'cover' => 'nullable|image|max:2048',
        ]);

        $book = Book::findOrFail($id);

        // Usar saga existente o nueva
        $book->saga = $request->newSaga ?: ($request->saga ?: '');
        $book->genre = $request->newGenre ?: $request->genre;
        $book->title = $request->title;
        $book->rating = $request->rating !== null ? $request->rating : null; // si no es null asigna lo que venga, si no asigna null
        $book->timestamps = false; // Desactiva timestamps por si acaso

        if ($request->hasFile('cover')) {
            $book->cover = $request->file('cover')->store('covers', 'public');
        }

        try {
            $book->save();
            return redirect()->route('books.index')->with('success', 'Libro actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un problema al actualizar el libro.');
        }
    }

    // Eliminar un libro por ID
    public function destroy($id)
    {
        Book::findOrFail($id)->delete();
        return response()->json(['message' => 'Libro eliminado']);
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $genres = Book::select('genre')->distinct()->pluck('genre')->sort();
        $sagas = Book::whereNotNull('saga')->where('saga', '!=', '')->distinct()->pluck('saga')->sort();

        return view('edit-book', compact('book', 'genres', 'sagas'));
    }

    public function exportCsv(Request $request)
    {
        $query = Book::query();

        // Aplicar filtros si existen
        if ($request->has('title') && !empty($request->title)) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->has('genre') && !empty($request->genre)) {
            $query->where('genre', $request->genre);
        }
        if ($request->has('rating') && !empty($request->rating)) {
            $query->where('rating', $request->rating);
        }

        // Ordenar por nota
        $books = $query->orderBy('rating', 'desc')->get();

        $csvFileName = 'books_filtered_export.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
        ];

        $callback = function () use ($books) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Título', 'Saga', 'Género', 'Nota']);

            foreach ($books as $book) {
                fputcsv($file, [$book->title, $book->saga, $book->genre, $book->rating]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
