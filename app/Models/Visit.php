<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class Visit extends Model
{
    use HasFactory;

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function responsibles()
    {
        return $this->belongsToMany(Responsible::class);
    }
}
