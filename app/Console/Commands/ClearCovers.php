<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearCovers extends Command
{
    protected $signature = 'covers:clear';
    protected $description = 'Elimina todas las portadas de la carpeta public/covers';

    public function handle()
    {
        Storage::deleteDirectory('public/covers');
        Storage::makeDirectory('public/covers');

        $this->info('Todas las portadas han sido eliminadas.');
    }
}