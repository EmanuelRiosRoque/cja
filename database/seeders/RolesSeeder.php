<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Limpia la caché de roles y permisos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | ROLES INSTITUCIONALES
        |--------------------------------------------------------------------------
        */
        $roles = [
            'SuperAdmin',
            'Admin',
            'Oficialía',
            'Administrador',
            'Coordinador',
            'Integrador',
            'Pleno',
        ];

        foreach ($roles as $rol) {
            Role::firstOrCreate([
                'name' => $rol,
                'guard_name' => 'web',
            ]);
        }
    }
}
