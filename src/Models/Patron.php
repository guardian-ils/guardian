<?php

namespace Guardian\Models;

class Patron extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'library_card_number',
      'name',
      'address',
      'phone',
      'email',
      'birthday',
      'branch_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
