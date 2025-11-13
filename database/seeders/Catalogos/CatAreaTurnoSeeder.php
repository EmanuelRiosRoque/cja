<?php

namespace Database\Seeders\Catalogos;

use App\Models\Catalogos\CatAreaTurno;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatAreaTurnoSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        $areas = [
            ['areaTurno' => 'Pleno'],
            ['areaTurno' => 'Seguimiento'],
            ['areaTurno' => 'Amparo'],
            ['areaTurno' => 'Varios'],
        ];

        foreach ($areas as $a) {
            CatAreaTurno::firstOrCreate(
                ['areaTurno' => $a['areaTurno']],
                [
                    'activo' => 1,
                    // 'fechaAlta' => $ahora,
                    // 'fechaModificacion' => $ahora,
                ]
            );
        }
    }
}
