<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    protected $fillable = [
        'disposal_id',
        'requester_name',
        'deed_of_donation_path',
        'released_at',
    ];

    protected function casts(): array
    {
        return [
            'released_at' => 'datetime',
        ];
    }

    public function disposal(): BelongsTo
    {
        return $this->belongsTo(Disposal::class);
    }
}
