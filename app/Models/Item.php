<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $incrementing = false;

    public function biblio()
    {
        return $this->belongsTo(Biblio::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}