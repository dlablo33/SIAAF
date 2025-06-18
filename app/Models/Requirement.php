<?php

// app/Models/Requirement.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'is_mandatory', 'depends_on'];

    public function dependentRequirements()
    {
        return $this->hasMany(Requirement::class, 'depends_on');
    }

    public function parentRequirement()
    {
        return $this->belongsTo(Requirement::class, 'depends_on');
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
}