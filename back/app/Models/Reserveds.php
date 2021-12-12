<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserveds extends Model
{
    // protected $with = ['houses'];
    protected $table = 'reserveds';
    public function houses()
    {
        return $this->belongsTo(House::class, 'house_id');
    }
    use HasFactory;
}
