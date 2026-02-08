<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }
}
