<?php

namespace Database\Seeders\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Catalogos\CatEstatus;

class CatEstatusSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        CatEstatus::query()->delete();

        DB::statement('ALTER TABLE catEstatus AUTO_INCREMENT = 1');

        $rows = [
            ['nombre' => 'Pendiente'],
            ['nombre' => 'Asignado'],
            ['nombre' => 'Rechazado'],
        ];

        foreach ($rows as $row) {
            CatEstatus::create([
                'nombre' => $row['nombre'],
                'activo' => 1,
                'fechaAlta' => $ahora,
                'fechaModificacion' => $ahora,
            ]);
        }
    }
}
