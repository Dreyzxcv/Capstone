<?php

namespace App\Enums;

enum AssetMode: string
{
    case Apprehended = 'apprehended';
    case Abandoned = 'abandoned';
    case TurnedOver = 'turned_over';

    public function label(): string
    {
        return match ($this) {
            self::Apprehended => 'Apprehended',
            self::Abandoned => 'Abandoned',
            self::TurnedOver => 'Turned Over',
        };
    }
}
