<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    /**
     * Lista fija de departamentos con sus IDs constantes
     */
    public const ADMINISTRACION = 1;
    public const ADMINISTRACION_INTERNA = 2;
    public const COMERCIAL = 3;
    public const COMERCIO_EXTERIOR = 4;
    public const CONTABILIDAD = 5;
    public const DIRECCION = 6;
    public const GERENCIA_GENERAL = 7;
    public const LEGAL_FISCAL = 8;
    public const NOMINAS = 9;
    public const RECURSOS_HUMANOS = 10;
    public const SISTEMAS = 11;

    /**
     * No usamos timestamps ya que son datos fijos
     */
    public $timestamps = false;

    /**
     * Atributos asignables masivamente
     */
    protected $fillable = ['name'];

    /**
     * Relación con usuarios
     */
    public function users(): HasMany
    {
        return $this->hasMany(Empleado::class);
    }

    /**
     * Obtener todos los departamentos disponibles
     *
     * @return array
     */
    public static function getAllDepartments(): array
    {
        return [
            self::ADMINISTRACION => 'Administración',
            self::ADMINISTRACION_INTERNA => 'Administración Interna',
            self::COMERCIAL => 'Comercial',
            self::COMERCIO_EXTERIOR => 'Comercio Exterior',
            self::CONTABILIDAD => 'Contabilidad',
            self::DIRECCION => 'Dirección',
            self::GERENCIA_GENERAL => 'Gerencia General',
            self::LEGAL_FISCAL => 'Legal-Fiscal',
            self::NOMINAS => 'Nominas',
            self::RECURSOS_HUMANOS => 'Recursos Humanos',
            self::SISTEMAS => 'Sistemas'
        ];
    }

    /**
     * Obtener nombre del departamento
     *
     * @param int $departmentId
     * @return string
     */
    public static function getDepartmentName(int $departmentId): string
    {
        return self::getAllDepartments()[$departmentId] ?? 'Desconocido';
    }

    /**
     * Verificar si un departamento existe
     *
     * @param int $departmentId
     * @return bool
     */
    public static function exists(int $departmentId): bool
    {
        return array_key_exists($departmentId, self::getAllDepartments());
    }
}
