<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    public function reponsibles()
    {
        return $this->belongsToMany(Responsible::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
