<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum NewsType: string implements HasColor, HasLabel
{
    case News = 'news';
    case PressRelease = 'press_release';
    case Announcement = 'announcement';

    public function label(): string
    {
        return match ($this) {
            self::News => 'News',
            self::PressRelease => 'Press Release',
            self::Announcement => 'Announcement',
        };
    }

    public function getLabel(): string
    {
        return $this->label();
    }

    public function getColor(): string
    {
        return match ($this) {
            self::News => 'primary',
            self::PressRelease => 'info',
            self::Announcement => 'warning',
        };
    }
}
