<?php

namespace Database\Seeders\Catalogos;

use App\Models\Catalogos\CatAdminJudicial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CatAdminJudicialSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        $ponencias = [
            ['nombre' => 'Secretaría Ejecutiva'],
            ['nombre' => 'Ponencia 1'],
            ['nombre' => 'Ponencia 2'],
            ['nombre' => 'Ponencia 3'],
            ['nombre' => 'Ponencia 4'],
            ['nombre' => 'Ponencia 5'],
        ];

        foreach ($ponencias as $p) {
            CatAdminJudicial::firstOrCreate(
                ['nombre' => $p['nombre']],
                [
                    'activo' => 1,
                    'fechaAlta' => $ahora,
                    'fechaModificacion' => $ahora,
                ]
            );
        }
    }
}
