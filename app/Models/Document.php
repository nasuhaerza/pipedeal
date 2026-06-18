<?php

namespace App\Models;

use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Document extends Model
{
    use HasFactory, BelongsToCompany;

    protected $fillable = [
        'company_id',
        'deal_id',
        'file_name',
        'file_path',
        'uploaded_by',
        'notes',
    ];

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getNameAttribute(): ?string
    {
        return $this->file_name;
    }

    public function setNameAttribute(string $value): void
    {
        $this->attributes['file_name'] = $value;
    }
}
