<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Presentador;
use Illuminate\Support\Carbon;

class PresentadoresSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        // IDs de las ponencias (asegúrate de que coincidan con los creados en AdminJudicialSeeder)
        $ponencias = [
            'Secretaría Ejecutiva' => 1,
            'Ponencia 1' => 2,
            'Ponencia 2' => 3,
            'Ponencia 3' => 4,
            'Ponencia 4' => 5,
            'Ponencia 5' => 6,
        ];

        $presentadores = [
            [
                'nombre' => 'Secretaría Ejecutiva',
                'cargo' => 'Secretaria Ejecutiva',
                'fk_adminJud' => $ponencias['Secretaría Ejecutiva'],
            ],
            [
                'nombre' => 'Mtra. Reyna Concepción Mince Serrano',
                'cargo' => 'Magistrada',
                'fk_adminJud' => $ponencias['Ponencia 1'],
            ],
            [
                'nombre' => 'Mag. Jorge Guerrero Meléndez',
                'cargo' => 'Magistrado',
                'fk_adminJud' => $ponencias['Ponencia 2'],
            ],
            [
                'nombre' => 'Mag. Víctor Hugo González Rodríguez',
                'cargo' => 'Magistrado',
                'fk_adminJud' => $ponencias['Ponencia 3'],
            ],
            [
                'nombre' => 'Mtra. Sara Alicia Alvarado Avendaño',
                'cargo' => 'Magistrada',
                'fk_adminJud' => $ponencias['Ponencia 4'],
            ],
            [
                'nombre' => 'Dr. Moisés Vergara Trejo',
                'cargo' => 'Magistrado',
                'fk_adminJud' => $ponencias['Ponencia 5'],
            ],
        ];

        foreach ($presentadores as $p) {
            Presentador::firstOrCreate(
                ['nombre' => $p['nombre']],
                [
                    'cargo' => $p['cargo'],
                    'fk_adminJud' => $p['fk_adminJud'],
                    'activo' => 1,
                    'fechaAlta' => $ahora,
                    'fechaModificacion' => $ahora,
                ]
            );
        }
    }
}
