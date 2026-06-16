<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'organizador@passaporte.io'],
            [
                'name'     => 'Organizador Teste',
                'password' => bcrypt('password'),
                'role'     => 'organizador',
            ]
        );

        User::firstOrCreate(
            ['email' => 'participante@passaporte.io'],
            [
                'name'     => 'Participante Teste',
                'password' => bcrypt('password'),
                'role'     => 'participante',
            ]
        );
    }
}
