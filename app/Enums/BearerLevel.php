<?php

namespace App\Enums;

enum BearerLevel: string
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
}
