<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heart extends Model
{
    use HasFactory;

    // protected $with = ['houses'];


    public function houses()
    {
        return $this->belongsTo(House::class, 'house_id');
    }
}
