<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany(Categorie::class, 'cate_opt');
    }

    public function caracteristique()
    {
        return $this->belongsTo(Caracteristique::class);
    }
}
