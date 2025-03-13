<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::resource('books', BookController::class)->except(['index', 'show']);
Route::post('/books/tabla', [BookController::class, 'index'])->name('books.tabla');
Route::get('/books/export/csv', [BookController::class, 'exportCsv'])->name('books.export.csv');