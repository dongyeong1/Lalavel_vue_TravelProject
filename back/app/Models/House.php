<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $with = ['reserveds', 'comments'];


    use HasFactory;
    public function hearts()
    {
        return $this->hasMany(Heart::class);
    }

    public function reserveds()
    {
        return $this->hasMany(Reserveds::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
