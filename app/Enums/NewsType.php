<?php

namespace App\Enums;

enum NewsType: string
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
}
