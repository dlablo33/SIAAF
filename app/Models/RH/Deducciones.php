<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deducciones extends Model
{

    use HasFactory;

    protected $table = 'cat_deducciones';

    protected $fillable = [
        'nombre',
        'id_estatus'
    ];

    // Relaciones
    public function estatus()
    {
        return $this->hasMany(Estatus::class);
    }
}
