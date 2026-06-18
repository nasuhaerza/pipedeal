<?php

namespace App\Models;

use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUp extends Model
{
    use HasFactory, BelongsToCompany;

    protected $table = 'followups';

    protected $fillable = [
        'company_id',
        'deal_id',
        'followup_date',
        'notes',
        'status',
    ];

    protected $casts = [
        'followup_date' => 'datetime',
    ];

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('followup_date', today());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function getScheduledAtAttribute()
    {
        return $this->followup_date;
    }

    public function setScheduledAtAttribute($value): void
    {
        $this->attributes['followup_date'] = $value;
    }
}
