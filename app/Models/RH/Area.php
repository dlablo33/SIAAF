<?php

namespace App\Models\RH;

use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    use HasFactory;

    protected $table = 'cat_area';

    protected $fillable = [
        'nombre',
        'id_estatus'
    ];

    // Relaciones
    public function estatus()
    {
        return $this->belongsTo(Estatus::class);
    }

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'id_area', 'id');
    }
}
