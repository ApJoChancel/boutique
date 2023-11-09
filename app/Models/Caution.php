<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caution extends Model
{
    use HasFactory;

    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }
}
