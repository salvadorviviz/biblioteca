<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->integer('rating')->nullable()->change(); // Permitir NULL en rating
        });

        // Actualizar valores 0 a NULL
        \DB::table('books')->where('rating', 0)->update(['rating' => null]);
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->integer('rating')->default(0)->change(); // Revertir cambio si se hace rollback
        });

        // Volver a establecer NULL como 0 si se revierte
        \DB::table('books')->whereNull('rating')->update(['rating' => 0]);
    }
};

