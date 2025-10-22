<?php

// app/Models/LegalAdvice.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalAdvice extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'empleado_id', 'topic', 'notes', 'date'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
