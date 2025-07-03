<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoHabitacion;

class TipoHabitacionesSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        $tipos = ['Estándar', 'Junior', 'Suite'];

        foreach ($tipos as $nombre) {
            TipoHabitacion::firstOrCreate(['nombre' => $nombre]);
        }
    }
}