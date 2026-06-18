<?php

namespace App\Models;

use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommissionShare extends Model
{
    use HasFactory, BelongsToCompany;

    protected $fillable = [
        'company_id',
        'deal_id',
        'user_id',
        'recipient_name',
        'commission_percent',
        'commission_amount',
    ];

    protected $casts = [
        'commission_percent' => 'decimal:2',
        'commission_amount' => 'decimal:2',
    ];

    public function getSharePercentageAttribute(): ?float
    {
        return $this->commission_percent;
    }

    public function setSharePercentageAttribute($value): void
    {
        $this->attributes['commission_percent'] = $value;
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
