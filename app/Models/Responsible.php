<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    use HasFactory;

    public function children()
    {
        return $this->belongsToMany(Child::class);
    }

    public function visits()
    {
        return $this->belongsToMany(Visit::class);
    }
}
