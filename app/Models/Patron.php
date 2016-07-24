<?php

namespace App\Models;

class Patron extends Model
{
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
