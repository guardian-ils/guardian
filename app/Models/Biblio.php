<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biblio extends Model
{
    public $incrementing = false;

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}