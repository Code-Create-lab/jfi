<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BearerLevel: string implements HasColor, HasLabel
{
    case National = 'national';
    case State = 'state';

    public function label(): string
    {
        return match ($this) {
            self::National => 'National',
            self::State => 'State',
        };
    }

    public function getLabel(): string
    {
        return $this->label();
    }

    public function getColor(): string
    {
        return match ($this) {
            self::National => 'primary',
            self::State => 'gray',
        };
    }
}
