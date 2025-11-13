<?php

namespace Database\Seeders\Catalogos;

use App\Models\Catalogos\CatAreaProcedencia;
use App\Models\Catalogos\CatAreaTurno;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CatAreaProcedenciaSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        $areas = [
            ['areaProcedencia' => 'Area 1'],
            ['areaProcedencia' => 'Area 2'],
            ['areaProcedencia' => 'Area 3'],
            ['areaProcedencia' => 'Area 4'],
            ['areaProcedencia' => 'Area 5'],
            ['areaProcedencia' => 'Area 6'],
            ['areaProcedencia' => 'Area 7'],
            ['areaProcedencia' => 'Area 8'],
            ['areaProcedencia' => 'Area 9'],
            ['areaProcedencia' => 'Area 10'],
    
        ];

        foreach ($areas as $a) {
            CatAreaProcedencia::firstOrCreate(
                ['areaProcedencia' => $a['areaProcedencia']],
                [
                    'activo' => 1,
                    // 'fechaAlta' => $ahora,
                    // 'fechaModificacion' => $ahora,
                ]
            );
        }
    }
}
