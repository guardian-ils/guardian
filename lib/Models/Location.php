<?php

namespace Guardian\Models;

class Location extends Model
{
    /**
     * Get parent branch
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
