<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    public function caracteristiques()
    {
        return $this->belongsToMany(Caracteristique::class, 'carac_cat');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
