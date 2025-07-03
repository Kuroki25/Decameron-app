<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelsSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            [
                'nombre'               => 'Hotel Sol de Oro',
                'direccion'            => 'Calle 10 #20-30',
                'ciudad'               => 'Bogotá',
                'nit'                  => '900100001-1',
                'num_habitaciones_max' => 200,
            ],
            [
                'nombre'               => 'Hotel Luna Azul',
                'direccion'            => 'Carrera 15 #45-67',
                'ciudad'               => 'Cali',
                'nit'                  => '900100002-2',
                'num_habitaciones_max' => 150,
            ],
            [
                'nombre'               => 'Hotel Mar y Arena',
                'direccion'            => 'Av. 5 de Junio #1-02',
                'ciudad'               => 'Cartagena',
                'nit'                  => '900100003-3',
                'num_habitaciones_max' => 100,
            ],
            [
                'nombre'               => 'Hotel Cumbres',
                'direccion'            => 'Calle 20 #10-15',
                'ciudad'               => 'Medellín',
                'nit'                  => '900100004-4',
                'num_habitaciones_max' => 120,
            ],
            [
                'nombre'               => 'Hotel Amazonia',
                'direccion'            => 'Carrera 1 #3-25',
                'ciudad'               => 'Leticia',
                'nit'                  => '900100005-5',
                'num_habitaciones_max' => 80,
            ],
            [
                'nombre'               => 'Hotel Llanos',
                'direccion'            => 'Av. Villavicencio #12-34',
                'ciudad'               => 'Villavicencio',
                'nit'                  => '900100006-6',
                'num_habitaciones_max' => 90,
            ],
            [
                'nombre'               => 'Hotel Pacífico',
                'direccion'            => 'Calle 2 #16-78',
                'ciudad'               => 'Buenaventura',
                'nit'                  => '900100007-7',
                'num_habitaciones_max' => 70,
            ],
            [
                'nombre'               => 'Hotel Caribe',
                'direccion'            => 'Carrera 5 #10-20',
                'ciudad'               => 'Santa Marta',
                'nit'                  => '900100008-8',
                'num_habitaciones_max' => 110,
            ],
            [
                'nombre'               => 'Hotel Andino',
                'direccion'            => 'Calle 8 #54-32',
                'ciudad'               => 'Bucaramanga',
                'nit'                  => '900100009-9',
                'num_habitaciones_max' => 95,
            ],
            [
                'nombre'               => 'Hotel Altiplano',
                'direccion'            => 'Av. Santander #3-14',
                'ciudad'               => 'Tunja',
                'nit'                  => '900100010-0',
                'num_habitaciones_max' => 60,
            ],
            [
                'nombre'               => 'Hotel Oasis',
                'direccion'            => 'Calle 12 #34-56',
                'ciudad'               => 'Neiva',
                'nit'                  => '900100011-1',
                'num_habitaciones_max' => 85,
            ],
            [
                'nombre'               => 'Hotel Imperial',
                'direccion'            => 'Carrera 7 #23-45',
                'ciudad'               => 'Popayán',
                'nit'                  => '900100012-2',
                'num_habitaciones_max' => 75,
            ],
            [
                'nombre'               => 'Hotel Confort',
                'direccion'            => 'Av. 20 de Julio #9-10',
                'ciudad'               => 'Pereira',
                'nit'                  => '900100013-3',
                'num_habitaciones_max' => 100,
            ],
            [
                'nombre'               => 'Hotel Roca',
                'direccion'            => 'Calle 14 #16-18',
                'ciudad'               => 'Manizales',
                'nit'                  => '900100014-4',
                'num_habitaciones_max' => 65,
            ],
            [
                'nombre'               => 'Hotel Estación',
                'direccion'            => 'Carrera 9 #5-12',
                'ciudad'               => 'Cúcuta',
                'nit'                  => '900100015-5',
                'num_habitaciones_max' => 80,
            ],
        ];

        foreach ($hotels as $data) {
            Hotel::updateOrCreate(
                ['nit' => $data['nit']],
                $data
            );
        }
    }
}
