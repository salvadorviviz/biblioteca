<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropTimestamps(); // Elimina created_at y updated_at
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->timestamps(); // En caso de rollback, los vuelve a agregar
        });
    }
};

