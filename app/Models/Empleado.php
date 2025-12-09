<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Department;
use App\Models\RH\Empresa;
use App\Models\RH\EsquemaPago;
use App\Models\RH\Papeleria;
use App\Models\RH\Puesto;
use App\Models\RH\VacacionesHistorial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'empleados';
    use SoftDeletes;

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

    // Relaciones
    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'id_puesto', 'id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id');
    }

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }

}
