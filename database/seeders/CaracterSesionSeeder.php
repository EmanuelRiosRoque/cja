<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CaracterSesion;

class CaracterSesionSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['nombre' => 'Pública', 'activo' => true],
            ['nombre' => 'Privada', 'activo' => true],
        ];

        foreach ($rows as $row) {
            CaracterSesion::updateOrCreate(
                $row
            );
        }
    }
}
