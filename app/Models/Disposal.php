<?php

namespace App\Models;

use App\Enums\DisposalType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Disposal extends Model
{
    protected $fillable = [
        'asset_id',
        'disposal_type',
        'details',
        'report_pdf_path',
        'processed_by',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'disposal_type' => DisposalType::class,
            'details' => 'array',
            'processed_at' => 'datetime',
        ];
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function donation(): HasOne
    {
        return $this->hasOne(Donation::class);
    }

    public function icsRecord(): HasOne
    {
        return $this->hasOne(IcsRecord::class);
    }

    public function parRecord(): HasOne
    {
        return $this->hasOne(ParRecord::class);
    }
}
