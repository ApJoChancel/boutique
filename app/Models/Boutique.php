<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    use HasFactory;

    public function manager()
    {
        return $this->hasOne(User::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
