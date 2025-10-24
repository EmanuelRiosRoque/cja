<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoSesion;

class TipoSesionSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['nombre' => 'Ordinaria',      'activo' => true],
            ['nombre' => 'Extraordinaria', 'activo' => true],
        ];

        foreach ($rows as $row) {
            TipoSesion::updateOrCreate(
                $row
            );
        }
    }
}
