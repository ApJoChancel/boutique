<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
