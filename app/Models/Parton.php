<?php

namespace App\Models;

class Parton extends Model
{
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}