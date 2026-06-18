<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PipelineStage extends Model
{
    use HasFactory;

    public const STAGES = [
        'Lead',
        'Qualification',
        'Proposal',
        'Negotiation',
        'Agreement',
        'Closed',
    ];

    protected $fillable = [
        'stage_name',
        'order_number',
    ];

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
}
