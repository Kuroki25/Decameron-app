<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Acomodacion;

class AcomodacionesSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        $acomodaciones = ['Sencilla', 'Doble', 'Triple', 'Cuádruple'];

        foreach ($acomodaciones as $nombre) {
            Acomodacion::firstOrCreate(['nombre' => $nombre]);
        }
    }
}