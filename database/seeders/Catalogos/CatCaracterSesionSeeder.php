<?php

namespace Database\Seeders\Catalogos;

use Illuminate\Database\Seeder;
use App\Models\Catalogos\CatCaracterSesion;
use Illuminate\Support\Carbon;

class CatCaracterSesionSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        $rows = [
            ['nombre' => 'Pública'],
            ['nombre' => 'Privada'],
        ];

        foreach ($rows as $row) {
            CatCaracterSesion::updateOrCreate(
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
