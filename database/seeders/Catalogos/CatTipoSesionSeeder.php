<?php

namespace Database\Seeders\Catalogos;

use App\Models\Catalogos\CatTipoSesion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CatTipoSesionSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        $rows = [
            ['nombre' => 'Ordinaria'],
            ['nombre' => 'Extraordinaria'],
        ];

        foreach ($rows as $row) {
            CatTipoSesion::updateOrCreate(
                ['nombre' => $row['nombre']],
                [
                    'activo' => 1,
                    'fechaAlta' => $ahora,
                    'fechaModificacion' => $ahora,
                ]
            );
        }
    }
}
