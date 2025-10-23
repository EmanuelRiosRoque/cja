<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['num_empleado' => '8009933'],
            [
                'name' => 'Usuario Desarrollador',
                'email' => 'dev@example.com',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
