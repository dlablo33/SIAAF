<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empleado::create([
            'id' => 1,
            'nombre' => 'Rogelio Gilberto',
            'a_paterno' => 'Garza',
            'a_materno' => 'Treviño',
            'correo_interno' => 'rogeliogarza@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2012-02-12',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 2,
            'nombre' => 'Fernando Jesse',
            'a_paterno' => 'Garza',
            'a_materno' => 'Gallegos',
            'correo_interno' => 'fernandogarza@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2020-06-01',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 3,
            'nombre' => 'Aracely',
            'a_paterno' => 'Vazquez',
            'a_materno' => 'Salinas',
            'correo_interno' => 'avazquez@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2012-03-05',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 4,
            'nombre' => 'Francisco Ramiro',
            'a_paterno' => 'Rodriguez',
            'a_materno' => 'Vargas',
            'correo_interno' => 'frodriguez@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2025-01-01',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 5,
            'nombre' => 'Emma Margarita',
            'a_paterno' => 'Martinez',
            'a_materno' => 'Garza',
            'correo_interno' => 'emartinez@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2014-08-25',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 7,
            'nombre' => 'Maribel',
            'a_paterno' => 'Vazquez',
            'a_materno' => 'Salinas',
            'correo_interno' => 'mvazquez@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2016-04-13',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 8,
            'nombre' => 'Lucero Iveth',
            'a_paterno' => 'Espinosa',
            'a_materno' => 'Cantu',
            'correo_interno' => 'lespinoza@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2021-05-31',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 9,
            'nombre' => 'Mario Alberto',
            'a_paterno' => 'Fernandez',
            'a_materno' => 'Rodriguez',
            'correo_interno' => 'mfernandez@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2012-12-19',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 11,
            'nombre' => 'Jose Santos',
            'a_paterno' => 'Niño',
            'a_materno' => 'Leos',
            'correo_interno' => 'jleos@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2016-09-27',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 12,
            'nombre' => 'Juan Ricardo',
            'a_paterno' => 'Ramirez',
            'a_materno' => 'Sanchez',
            'correo_interno' => 'rramirez@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2012-06-08',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 13,
            'nombre' => 'Cesar Agusto',
            'a_paterno' => 'Costa',
            'a_materno' => 'Leal',
            'correo_interno' => 'admin@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2021-11-22',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 14,
            'nombre' => 'Heriberto',
            'a_paterno' => 'Lomas',
            'a_materno' => 'Cruz',
            'correo_interno' => 'hlomas@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2012-01-16',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 16,
            'nombre' => 'Ivan',
            'a_paterno' => 'Cordova',
            'a_materno' => 'de la Cruz',
            'correo_interno' => 'icordova@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2022-03-01',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 17,
            'nombre' => 'Cesar Alejandro',
            'a_paterno' => 'Saucedo',
            'a_materno' => 'Lopez',
            'correo_interno' => 'csaucedo@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2024-02-27',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 18,
            'nombre' => 'Norma Patricia',
            'a_paterno' => 'Burciaga',
            'a_materno' => 'Ruiz',
            'correo_interno' => 'pburciaga@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2022-03-23',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 19,
            'nombre' => 'Edwin Jair',
            'a_paterno' => 'Vital',
            'a_materno' => 'Sanchez',
            'correo_interno' => 'evital@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2021-11-29',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 21,
            'nombre' => 'Lorenza',
            'a_paterno' => 'Arredondo',
            'a_materno' => 'Juarez',
            'id_empresa' => 1,
            'fecha_ingreso' => '2015-04-09',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 22,
            'nombre' => 'Brenda Navil',
            'a_paterno' => 'Gatika',
            'a_materno' => 'Rodriguez',
            'id_empresa' => 1,
            'fecha_ingreso' => '2021-11-01',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 23,
            'nombre' => 'Pamela',
            'a_paterno' => 'Alexander',
            'a_materno' => 'Guerra',
            'correo_interno' => 'palexander@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2020-06-01',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 24,
            'nombre' => 'Karen Lucero',
            'a_paterno' => 'Robles',
            'a_materno' => 'Perez',
            'correo_interno' => 'krobles@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2021-04-26',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 26,
            'nombre' => 'Juan Manuel',
            'a_paterno' => 'Cornejo',
            'a_materno' => 'Gutierrez',
            'correo_interno' => 'jmcornejo@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2020-06-01',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 27,
            'nombre' => 'Rogelio',
            'a_paterno' => 'Garza',
            'a_materno' => 'Galindo',
            'correo_interno' => 'a@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2012-01-01',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 28,
            'nombre' => 'Nissi Jazmin',
            'a_paterno' => 'Lomas',
            'a_materno' => 'Cruz',
            'correo_interno' => 'nlomas@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2017-10-30',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 29,
            'nombre' => 'Mauricio Adrian',
            'a_paterno' => 'Ramirez',
            'a_materno' => 'Aviles',
            'correo_interno' => 'mramirez@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2023-11-01',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 30,
            'nombre' => 'Aydee Anai',
            'a_paterno' => 'Cantu',
            'a_materno' => 'Gonzalez',
            'correo_interno' => 'acantu@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2024-04-01',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 31,
            'nombre' => 'Paola Sofia',
            'a_paterno' => 'Evangelista',
            'a_materno' => 'Mendoza',
            'correo_interno' => 'pmendoza@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2025-05-13',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 32,
            'nombre' => 'Luis Carlos',
            'a_paterno' => 'Garcia',
            'a_materno' => 'Silvestre',
            'correo_interno' => 'cgarcia@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2025-05-19',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 33,
            'nombre' => 'Benjamin',
            'a_paterno' => 'Ramirez',
            'a_materno' => 'Saucedo',
            'correo_interno' => 'bramirez@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2024-04-22',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 36,
            'nombre' => 'Angelica',
            'a_paterno' => 'Hernandez',
            'a_materno' => 'Sierra',
            'correo_interno' => 'ahernandez@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2024-06-17',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 37,
            'nombre' => 'Diego',
            'a_paterno' => 'de Alejandro',
            'a_materno' => 'Treviño',
            'correo_interno' => 'dalejandro@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2024-06-18',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 40,
            'nombre' => 'Alvaro Antonio',
            'a_paterno' => 'Limon',
            'a_materno' => 'Lozano',
            'correo_interno' => 'alimon@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2024-07-15',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 41,
            'nombre' => 'Jhoinner Steven',
            'a_paterno' => 'Lerma',
            'a_materno' => 'Roman',
            'correo_interno' => 'jlerma@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2024-09-11',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 42,
            'nombre' => 'Esmeralda',
            'a_paterno' => 'Gonzales',
            'a_materno' => 'Salas',
            'id_empresa' => 1,
            'fecha_ingreso' => '2024-08-25',
            'id_estatus' => 1,
        ]);

        Empleado::create([
            'id' => 44,
            'nombre' => 'Mario Alberto',
            'a_paterno' => 'Castañeda',
            'a_materno' => 'Guzman',
            'correo_interno' => 'mcastaneda@aaf.mx',
            'id_empresa' => 1,
            'fecha_ingreso' => '2024-09-17',
            'id_estatus' => 1,
        ]);


    }
}
