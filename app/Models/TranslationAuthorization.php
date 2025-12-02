<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TranslationAuthorization extends Model
{
    protected $fillable = [
        'original_pattern_id',
        'translator_id',
        'approved_by',
        'status',
        'notes',
    ];

    public function originalPattern(): BelongsTo
    {
        return $this->belongsTo(Pattern::class, 'original_pattern_id');
    }

    public function translator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'translator_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
