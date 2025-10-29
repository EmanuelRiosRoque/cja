<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Presentador;

class PresentadoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $presentadores = [
            [
                'nombre' => 'Secretaría Ejecutiva',
                'cargo' => 'Secretaria Ejecutiva',
            ],
            [
                'nombre' => 'Ponencia 1 - Mtra. Reyna Concepción Mince Serrano',
                'cargo' => 'Magistrada',
            ],
            [
                'nombre' => 'Ponencia 2 - Mag. Jorge Guerrero Meléndez',
                'cargo' => 'Magistrado',
            ],
            [
                'nombre' => 'Ponencia 3 - Mag. Víctor Hugo González Rodríguez',
                'cargo' => 'Magistrado',
            ],
            [
                'nombre' => 'Ponencia 4 - Mtra. Sara Alicia Alvarado Avendaño',
                'cargo' => 'Magistrada',
            ],
            [
                'nombre' => 'Ponencia 5 - Dr. Moisés Vergara Trejo',
                'cargo' => 'Magistrado',
            ],
        ];

        foreach ($presentadores as $p) {
            Presentador::create($p);
        }
    }
}
