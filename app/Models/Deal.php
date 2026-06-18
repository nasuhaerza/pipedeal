<?php

namespace App\Models;

use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deal extends Model
{
    use HasFactory, BelongsToCompany;

    protected $fillable = [
        'company_id',
        'client_id',
        'created_by',
        'stage_id',
        'deal_name',
        'deal_value',
        'expected_close_date',
        'notes',
        'pipeline_stage_id',
        'title',
        'amount',
        'closed_at',
    ];

    protected $casts = [
        'deal_value' => 'decimal:2',
        'expected_close_date' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(PipelineStage::class, 'stage_id');
    }

    public function commissionShares(): HasMany
    {
        return $this->hasMany(CommissionShare::class);
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function activities(): HasMany
    {
        return $this->activityLogs();
    }

    public function getFormattedDealValueAttribute(): string
    {
        return 'Rp ' . number_format($this->deal_value, 0, ',', '.');
    }

    public function getTitleAttribute(): ?string
    {
        return $this->deal_name;
    }

    public function setTitleAttribute(?string $value): void
    {
        $this->attributes['deal_name'] = $value;
    }

    public function getAmountAttribute(): float
    {
        return $this->deal_value;
    }

    public function setAmountAttribute(float $value): void
    {
        $this->attributes['deal_value'] = $value;
    }

    public function getClosedAtAttribute(): ?\Illuminate\Support\Carbon\Carbon
    {
        return $this->expected_close_date;
    }

    public function setClosedAtAttribute($value): void
    {
        $this->attributes['expected_close_date'] = $value;
    }

    public function getPipelineStageIdAttribute(): ?int
    {
        return $this->stage_id;
    }

    public function setPipelineStageIdAttribute($value): void
    {
        $this->attributes['stage_id'] = $value;
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByStage($query, $stageId)
    {
        return $query->where('stage_id', $stageId);
    }
}
