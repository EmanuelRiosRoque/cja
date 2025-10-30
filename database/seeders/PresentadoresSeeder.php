<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Presentador;
use App\Models\Ponencia;

class PresentadoresSeeder extends Seeder
{
    public function run(): void
    {
        // Nos aseguramos de que existan las ponencias
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
                'ponencia_id' => $ponencias['Secretaría Ejecutiva'],
            ],
            [
                'nombre' => 'Mtra. Reyna Concepción Mince Serrano',
                'cargo' => 'Magistrada',
                'ponencia_id' => $ponencias['Ponencia 1'],
            ],
            [
                'nombre' => 'Mag. Jorge Guerrero Meléndez',
                'cargo' => 'Magistrado',
                'ponencia_id' => $ponencias['Ponencia 2'],
            ],
            [
                'nombre' => 'Mag. Víctor Hugo González Rodríguez',
                'cargo' => 'Magistrado',
                'ponencia_id' => $ponencias['Ponencia 3'],
            ],
            [
                'nombre' => 'Mtra. Sara Alicia Alvarado Avendaño',
                'cargo' => 'Magistrada',
                'ponencia_id' => $ponencias['Ponencia 4'],
            ],
            [
                'nombre' => 'Dr. Moisés Vergara Trejo',
                'cargo' => 'Magistrado',
                'ponencia_id' => $ponencias['Ponencia 5'],
            ],
        ];

        foreach ($presentadores as $p) {
            Presentador::firstOrCreate([
                'nombre' => $p['nombre'],
            ], $p);
        }
    }
}
