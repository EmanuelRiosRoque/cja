<?php

namespace Database\Seeders\Catalogos;

use App\Models\Catalogos\CatTipoProcedencia;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatTipoProcedenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ahora = Carbon::now();

        $rows = [
            ['tipoProcedencia' => 'Interno'],
            ['tipoProcedencia' => 'Externo'],
            ['tipoProcedencia' => 'Particular'],
        ];

        foreach ($rows as $row) {
            CatTipoProcedencia::updateOrCreate(
                ['tipoProcedencia' => $row['tipoProcedencia']],
                [
                    'activo' => 1,
                    // 'fechaAlta' => $ahora,
                    // 'fechaModificacion' => $ahora,
                ]
            );
        }
    }
}
