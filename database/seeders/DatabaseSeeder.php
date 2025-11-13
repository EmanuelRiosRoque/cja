<?php

namespace Database\Seeders;

use Database\Seeders\Catalogos\CatAdminJudicialSeeder;
use Database\Seeders\Catalogos\CatAnexoSeeder;
use Database\Seeders\Catalogos\CatAreaProcedenciaSeeder;
use Database\Seeders\Catalogos\CatAreaTurnoSeeder;
use Database\Seeders\Catalogos\CatCaracterSesionSeeder;
use Database\Seeders\Catalogos\CatEntregaSeeder;
use Database\Seeders\Catalogos\CatEstatusSeeder;
use Database\Seeders\Catalogos\CatRolesSeeder;
use Database\Seeders\Catalogos\CatSedeSeeder;
use Database\Seeders\Catalogos\CatTipoDocSeeder;
use Database\Seeders\Catalogos\CatTipoProcedenciaSeeder;
use Database\Seeders\Catalogos\CatTipoSesionSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
          $this->call([
            UserSeeder::class,
            PresentadoresSeeder::class,
              
            //Catalogos
            CatRolesSeeder::class,
            CatEstatusSeeder::class,
            CatAdminJudicialSeeder::class,
            CatCaracterSesionSeeder::class,
            CatSedeSeeder::class,
            CatTipoSesionSeeder::class,
            CatEntregaSeeder::class,
            CatTipoProcedenciaSeeder::class,
            CatAreaProcedenciaSeeder::class,
            CatAreaTurnoSeeder::class,
            CatTipoDocSeeder::class,
            CatAnexoSeeder::class,
        ]);

    }
}
