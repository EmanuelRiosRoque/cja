<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sede;

class SedeSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['nombre' => 'Niños Héroes 132','activo' => true],
        ];

        foreach ($rows as $row) {
            Sede::updateOrCreate(
                $row
            );
        }
    }
}
