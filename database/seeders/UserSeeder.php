<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            // SUPER ADMIN
            [
                'name' => 'Usuario Desarrollador',
                'email' => 'dev@example.com',
                'num_empleado' => '8009933',
                'password' => Hash::make('12345678'),
                'adminJud' => null,
                'rol' => 'SuperAdmin',
            ],

            // ADMIN GENERAL
            [
                'name' => 'Admin General',
                'email' => 'admin@example.com',
                'num_empleado' => '8001000',
                'password' => Hash::make('12345678'),
                'adminJud' => null,
                'rol' => 'Admin',
            ],

            // SECRETARÍA EJECUTIVA
            [
                'name' => 'Secretaría Ejecutiva',
                'email' => 'secretaria@example.com',
                'num_empleado' => '9001001',
                'password' => Hash::make('12345678'),
                'adminJud' => null,
                'rol' => 'Oficialía',
            ],

            // PONENCIAS
            [
                'name' => 'Mtra. Reyna Concepción Mince Serrano',
                'email' => 'ponencia1@example.com',
                'num_empleado' => '9002001',
                'password' => Hash::make('12345678'),
                'adminJud' => null,
                'rol' => 'Administrador',
            ],
            [
                'name' => 'Mag. Jorge Guerrero Meléndez',
                'email' => 'ponencia2@example.com',
                'num_empleado' => '9002002',
                'password' => Hash::make('12345678'),
                'adminJud' => null,
                'rol' => 'Administrador',
            ],
            [
                'name' => 'Mag. Víctor Hugo González Rodríguez',
                'email' => 'ponencia3@example.com',
                'num_empleado' => '9002003',
                'password' => Hash::make('12345678'),
                'adminJud' => null,
                'rol' => 'Administrador',
            ],
            [
                'name' => 'Mtra. Sara Alicia Alvarado Avendaño',
                'email' => 'ponencia4@example.com',
                'num_empleado' => '9002004',
                'password' => Hash::make('12345678'),
                'adminJud' => null,
                'rol' => 'Administrador',
            ],
            [
                'name' => 'Dr. Moisés Vergara Trejo',
                'email' => 'ponencia5@example.com',
                'num_empleado' => '9002005',
                'password' => Hash::make('12345678'),
                'adminJud' => null,
                'rol' => 'Administrador',
            ],

            // COORDINADOR Y PLENO
            [
                'name' => 'Coordinador General',
                'email' => 'coordinador@example.com',
                'num_empleado' => '9101001',
                'password' => Hash::make('12345678'),
                'adminJud' => null,
                'rol' => 'Coordinador',
            ],
            [
                'name' => 'Integrador del Pleno',
                'email' => 'pleno@example.com',
                'num_empleado' => '9201001',
                'password' => Hash::make('12345678'),
                'adminJud' => null,
                'rol' => 'Pleno',
            ],

            [
                'name' => 'Oficialía',
                'email' => 'oficilia@example.com',
                'num_empleado' => '9201002',
                'password' => Hash::make('12345678'),
                'adminJud' => null,
                'rol' => 'Oficialía',
            ],
        ];

        foreach ($usuarios as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                collect($data)->except('rol')->toArray()
            );

            // Aseguramos que el rol exista antes de asignarlo
            if (isset($data['rol']) && method_exists($user, 'assignRole')) {
                $role = Role::firstOrCreate([
                    'name' => $data['rol'],
                    'guard_name' => 'web',
                ]);

                $user->assignRole($role);
            }
        }
    }
}
