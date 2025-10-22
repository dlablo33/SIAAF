<?php

namespace App\Models\RH;

use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deducciones extends Model
{
    use SoftDeletes;
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
