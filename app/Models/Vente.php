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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    public function caution()
    {
        return $this->hasOne(Caution::class);
    }
}
