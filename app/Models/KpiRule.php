<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KpiRule extends Model
{
    protected $fillable = [
        'kpi_id',
        'rule_expression',
        'severity',
        'is_active',
    ];

    public function kpi(): BelongsTo
    {
        return $this->belongsTo(Kpi::class);
    }
}
