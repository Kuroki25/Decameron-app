<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;

class HotelTipoAcomodacionSeeder extends Seeder
{
    public function run(): void
    {
        $tipoIds  = DB::table('tipo_habitaciones')->pluck('id')->toArray();
        $acomIds  = DB::table('acomodaciones')->pluck('id')->toArray();

        Hotel::all()->each(function (Hotel $hotel) use ($tipoIds, $acomIds) {
            foreach ($tipoIds as $tipoId) {
                foreach ($acomIds as $acomId) {
                    $hotel->asignaciones()->updateOrCreate(
                        [
                            'tipo_habitacion_id' => $tipoId,
                            'acomodacion_id'     => $acomId,
                        ],
                        [
                            // repartimos aleatoriamente, no exceder el máximo
                            'cantidad' => rand(1, max(1, floor($hotel->num_habitaciones_max / count($acomIds)))),
                        ]
                    );
                }
            }
        });
    }
}
