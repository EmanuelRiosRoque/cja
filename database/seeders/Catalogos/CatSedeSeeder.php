<?php

namespace Database\Seeders\Catalogos;

use App\Models\Catalogos\CatSede;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CatSedeSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        $rows = [
            ['nombre' => 'Niños Héroes 132'],
        ];

        foreach ($rows as $row) {
            CatSede::updateOrCreate(
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
