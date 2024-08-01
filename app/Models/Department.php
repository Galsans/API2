<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the divisi that owns the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
}
