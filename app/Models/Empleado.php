<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Department;
use App\Models\HR\EsquemaPago;
use App\Models\HR\Papeleria;
use App\Models\HR\VacacionesHistorial;

class Empleado extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
        'email',
        'password',
        'role', // Añade este campo
        'foto_perfil',
        'curp',
        'rfc',
        'nss',
        'fecha_nacimiento',
        'domicilio',
        'telefono',
        'contacto',
        'telefono_contacto',
        'empresa',
        'puesto',
        'fecha_ingreso',
        'vac_restante'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdministrador()
    {
        return $this->role === 'administrador';
    }

    public function isGerente()
    {
        return $this->role === 'gerente';
    }

    public function isCoordinador()
    {
        return $this->role === 'coordinador';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function esquemaPago()
    {
        return $this->hasMany(EsquemaPago::class);
    }

    public function vacacionesHistorial()
    {
        return $this->hasMany(VacacionesHistorial::class);
    }

    public function papeleria()
    {
        return $this->hasMany(Papeleria::class);
    }
}
