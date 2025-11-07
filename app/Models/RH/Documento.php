<?php

namespace App\Models\RH;

use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{

    use HasFactory;

    protected $table = 'cat_documentos';

    protected $fillable = [
        'nombre',
        'vigencia',
        'id_estatus'
    ];

    // Relaciones
    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }
}
