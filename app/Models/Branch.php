<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Branch extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
}
