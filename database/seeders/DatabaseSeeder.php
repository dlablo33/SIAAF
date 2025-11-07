<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Estatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Estatus::create([
            'id' => 1,
            'descripcion' => 'Activo',
        ]);

        Estatus::create([
            'id' => 2,
            'descripcion' => 'Inactivo',
        ]);

        $this->call([
            EmpleadoSeeder::class,
            UserSeeder::class,
            NominaSeeder::class
        ]);

        // // Usuario Administrador
        // User::create([
        //     'name' => 'Administrador Principal',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('password123'), // Cambia esto en producción
        //     'role' => 'administrador'
        // ]);

        // // Usuario Gerente
        // User::create([
        //     'name' => 'Gerente Ejemplo',
        //     'email' => 'gerente@example.com',
        //     'password' => Hash::make('password123'),
        //     'role' => 'gerente'
        // ]);

        // // Usuario Coordinador
        // User::create([
        //     'name' => 'Coordinador Demo',
        //     'email' => 'coordinador@example.com',
        //     'password' => Hash::make('password123'),
        //     'role' => 'coordinador'
        // ]);

        // // Usuario Staff (rol por defecto)
        // User::create([
        //     'name' => 'Staff Regular',
        //     'email' => 'staff@example.com',
        //     'password' => Hash::make('password123'),
        //     'role' => 'staff'
        // ]);

        // // Usuarios adicionales de prueba
        // User::factory(5)->create([
        //     'role' => 'staff'
        // ]);

        // // Si necesitas más usuarios con roles específicos
        // User::factory()->create([
        //     'name' => 'Segundo Administrador',
        //     'email' => 'admin2@example.com',
        //     'password' => Hash::make('password123'),
        //     'role' => 'administrador'
        // ]);

        //     foreach (Department::getAllDepartments() as $id => $name) {
        // Department::updateOrCreate(
        //     ['id' => $id],
        //     ['name' => $name]
        // );
    }
}
