<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comida;

class ComidasTableSeeder extends Seeder
{
    public function run()
    {
        Comida::create(['nombre' => 'Hamburguesa', 'tipo' => 'Rápida', 'precio' => 8.50]);
        Comida::create(['nombre' => 'Pizza',       'tipo' => 'Italiana', 'precio' => 12.99]);
        Comida::create(['nombre' => 'Ensalada',    'tipo' => 'Saludable', 'precio' => 6.75]);
    }
}
