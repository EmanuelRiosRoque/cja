<?php

namespace Database\Seeders\Catalogos;

use App\Models\Catalogos\CatTipoDoc;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTipoDocSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        CatTipoDoc::query()->delete();

        DB::statement('ALTER TABLE catTipoDoc AUTO_INCREMENT = 1');

        $rows = [
            ['tipoDoc' => 'Original'],
            ['tipoDoc' => 'Copia'],
        ];

        foreach ($rows as $row) {
            CatTipoDoc::create([
                'tipoDoc' => $row['tipoDoc'],
                'activo' => 1,
                // 'fechaAlta' => $ahora,
                // 'fechaModificacion' => $ahora,
            ]);
        }
    }
}
