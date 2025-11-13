<?php

namespace Database\Seeders\Catalogos;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Catalogos\CatEntrega;

class CatEntregaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ahora = Carbon::now();

        $rows = [
            ['entrega' => 'OPV'],
            ['entrega' => 'OPF'],
            ['entrega' => 'SICAPOAJ'],
        ];

        foreach ($rows as $row) {
            CatEntrega::updateOrCreate(
                ['entrega' => $row['entrega']],
                [
                    'activo' => 1,
                    // 'fechaAlta' => $ahora,
                    // 'fechaModificacion' => $ahora,
                ]
            );
        }
    }
}
