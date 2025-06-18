<?php

// app/Models/LegalProcedure.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalProcedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'status', 'client_id', 'user_id', 'start_date', 'end_date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}