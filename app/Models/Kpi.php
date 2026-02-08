<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kpi extends Model
{
    protected $fillable = [
        'course_id',
        'name',
        'weight',
        'target',
        'status',
        'description',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function rules(): HasMany
    {
        return $this->hasMany(KpiRule::class);
    }
}
