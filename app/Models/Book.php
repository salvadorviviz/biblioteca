<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Nombre de la tabla en la BD (opcional, pero recomendable si el nombre no sigue la convención)
    protected $table = 'books';

    // Por si da problemas con el null
    protected $casts = ['rating' => 'integer'];    

    // Campos que se pueden llenar de manera masiva
    protected $fillable = ['title', 'genre', 'saga', 'rating', 'cover'];

    // Evita que Laravel intente actualizar `created_at` y `updated_at`
    public $timestamps = false; 
}
