<?php

namespace Guardian\Models;

class Item extends Model
{

    public function biblio()
    {
        return $this->belongsTo(Biblio::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
