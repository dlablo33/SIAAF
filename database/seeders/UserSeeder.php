<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => 'Cesar Saucedo',
            'email' => 'csaucedo@aaf.mx',
            'password' => '$2y$12$lNnXG0hfzc7T/lFwmYwk3ODaOFSqG.EenMj/',
            'role' => 'administrador'
        ]);

        User::create([
            'id' => 2,
            'name' => 'Carlos Garcia',
            'email' => 'cgarcia@aaf.mx',
            'password' => '$2y$12$8JjyZHSWZrerpIp9bRHjKOUq/F6vGf11aCVxTwVogtWNMLq3.04qa',
            'role' => 'administrador'
        ]);
    }
}