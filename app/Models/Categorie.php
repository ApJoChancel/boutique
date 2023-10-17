<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    public function options()
    {
        return $this->belongsToMany(Option::class, 'cate_opt');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
