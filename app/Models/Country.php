<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
