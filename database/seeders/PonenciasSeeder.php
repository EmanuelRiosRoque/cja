<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ponencia;

class PonenciasSeeder extends Seeder
{
    public function run(): void
    {
        $ponencias = [
            ['nombre' => 'Secretaría Ejecutiva'],
            ['nombre' => 'Ponencia 1'],
            ['nombre' => 'Ponencia 2'],
            ['nombre' => 'Ponencia 3'],
            ['nombre' => 'Ponencia 4'],
            ['nombre' => 'Ponencia 5'],
        ];

        foreach ($ponencias as $p) {
            Ponencia::firstOrCreate($p);
        }
    }
}
