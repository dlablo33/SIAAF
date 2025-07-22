<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Department;
use App\Models\HR\EsquemaPago;
use App\Models\HR\Papeleria;
use App\Models\HR\VacacionesHistorial;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'empleados';

    protected $fillable = [
        'nombre',
        'a_paterno',
        'a_materno',
        'correo_interno',
        'correo_personal',
        'foto_perfil',
        'curp',
        'rfc',
        'nss',
        'fecha_nacimiento',
        'genero',
        'nacionalidad',
        'id_domicilio',
        'telefono',
        'contacto',
        'contacto_telefono',
        'id_empresa',
        'id_puesto',
        'fecha_ingreso',
        'fecha_baja',
        'fecha_reingreso',
        'id_estatus'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

}
