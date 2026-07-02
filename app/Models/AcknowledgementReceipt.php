<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcknowledgementReceipt extends Model
{
    protected $fillable = [
        'asset_id',
        'receipt_number',
        'signed_by_custodian_id',
        'signed_at',
        'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'signed_at' => 'datetime',
        ];
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function signedByCustodian(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signed_by_custodian_id');
    }
}
