<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the department for the Divisi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function department()
    {
        return $this->hasMany(Department::class);
    }
}
