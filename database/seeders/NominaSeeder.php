<?php

namespace Database\Seeders;

use App\Models\RH\Deducciones;
use App\Models\RH\Prestaciones;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NominaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prestaciones::create([
            'id' => 1,
            'nombre' => 'Sueldo',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Prestaciones::create([
            'id' => 2,
            'nombre' => '7mo Dia',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Prestaciones::create([
            'id' => 3,
            'nombre' => 'Bono Puntualidad',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Prestaciones::create([
            'id' => 4,
            'nombre' => 'Bono Asistencia',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Prestaciones::create([
            'id' => 5,
            'nombre' => 'Despensa',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Prestaciones::create([
            'id' => 6,
            'nombre' => 'Bono Mensual',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Prestaciones::create([
            'id' => 7,
            'nombre' => 'Vacaciones',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Prestaciones::create([
            'id' => 8,
            'nombre' => 'Prima Vacacional',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Deducciones::create([
            'id' => 1,
            'nombre' => 'Faltas',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Deducciones::create([
            'id' => 2,
            'nombre' => 'Descuento Vacaciones',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Deducciones::create([
            'id' => 3,
            'nombre' => 'Retardos',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Deducciones::create([
            'id' => 4,
            'nombre' => 'Adelanto de Nomina',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Deducciones::create([
            'id' => 5,
            'nombre' => 'Prestamo',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Deducciones::create([
            'id' => 6,
            'nombre' => 'Comedor',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Deducciones::create([
            'id' => 7,
            'nombre' => 'Seguro',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);

        Deducciones::create([
            'id' => 8,
            'nombre' => 'IMSS/ISR',
            'id_estatus' => 1,
            'created_at' => '2025-08-11 18:17:21'
        ]);
    }
}
