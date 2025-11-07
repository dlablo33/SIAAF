<?php

// app/Models/Company.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'legal_name', 'commercial_name', 'rfc', 'phone', 'address',
        'legal_representative', 'company_type', 'partners_details', 'client_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}