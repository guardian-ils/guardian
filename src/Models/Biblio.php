<?php

namespace Guardian\Models;

use Illuminate\Database\Eloquent\Model;

class Biblio extends Model
{
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
