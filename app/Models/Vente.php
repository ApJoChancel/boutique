<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    public function ligneVentes()
    {
        return $this->hasMany(LigneVente::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
