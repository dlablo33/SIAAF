<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Empleado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario Administrador
        Empleado::create([
            'name' => 'Administrador Principal',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // Cambia esto en producción
            'role' => 'administrador'
        ]);

        // Usuario Gerente
        Empleado::create([
            'name' => 'Gerente Ejemplo',
            'email' => 'gerente@example.com',
            'password' => Hash::make('password123'),
            'role' => 'gerente'
        ]);

        // Usuario Coordinador
        Empleado::create([
            'name' => 'Coordinador Demo',
            'email' => 'coordinador@example.com',
            'password' => Hash::make('password123'),
            'role' => 'coordinador'
        ]);

        // Usuario Staff (rol por defecto)
        Empleado::create([
            'name' => 'Staff Regular',
            'email' => 'staff@example.com',
            'password' => Hash::make('password123'),
            'role' => 'staff'
        ]);

        // Usuarios adicionales de prueba
        Empleado::factory(5)->create([
            'role' => 'staff'
        ]);

        // Si necesitas más usuarios con roles específicos
        Empleado::factory()->create([
            'name' => 'Segundo Administrador',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'administrador'
        ]);

            foreach (Department::getAllDepartments() as $id => $name) {
        Department::updateOrCreate(
            ['id' => $id],
            ['name' => $name]
        );
    }
}
}
