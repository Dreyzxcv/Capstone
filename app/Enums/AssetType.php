<?php

namespace App\Enums;

enum AssetType: string
{
    case Log = 'log';
    case Equipment = 'equipment';
    case Vehicle = 'vehicle';

    public function label(): string
    {
        return match ($this) {
            self::Log => 'Log / Lumber',
            self::Equipment => 'Equipment / Tools',
            self::Vehicle => 'Conveyance / Vehicle',
        };
    }
}
