<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $with = ['users'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function houses()
    {
        return $this->belongsTo(House::class, 'house_id');
    }
}
