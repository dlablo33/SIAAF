<?php

// app/Models/Document.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'category', 'issue_date', 'expiration_date', 'is_valid', 'client_id', 'file_path'
    ];

    protected $dates = ['issue_date', 'expiration_date'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function requirements()
    {
        return $this->belongsToMany(Requirement::class);
    }
}