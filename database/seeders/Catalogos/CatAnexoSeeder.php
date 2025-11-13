<?php

namespace Database\Seeders\Catalogos;

use App\Models\Catalogos\CatAnexo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatAnexoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ahora = Carbon::now();

        $areas = [
            ['anexo' => 'Si'],
            ['anexo' => 'No'],
        ];

        foreach ($areas as $a) {
            CatAnexo::firstOrCreate(
                ['anexo' => $a['anexo']],
                [
                    'activo' => 1,
                    // 'fechaAlta' => $ahora,
                    // 'fechaModificacion' => $ahora,
                ]
            );
        }
    }
}
