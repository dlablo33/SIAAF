<?php

namespace App\Models\RH;

use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrestamoHistorial extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'prestamo_historial';

    protected $fillable = [
        'id_prestamo',
        'fecha',
        'pago',
    ];

    // Relaciones
    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'id_prestamo', 'id');
    }
}
