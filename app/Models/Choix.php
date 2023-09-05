<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choix extends Model
{
    use HasFactory;

    protected $table = 'choix';

    public function question()
    {
       return $this->belongsTo(Question::class);
    }

    public function sousChoix()
    {
        return $this->hasMany(Choix::class);
    }
}
