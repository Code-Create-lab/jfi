<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DownloadCategory: string implements HasLabel
{
    case RuleBook = 'rule_book';
    case Circular = 'circular';
    case Notice = 'notice';
    case Form = 'form';
    case Document = 'document';

    public function label(): string
    {
        return match ($this) {
            self::RuleBook => 'Rule Book',
            self::Circular => 'Circular',
            self::Notice => 'Notice',
            self::Form => 'Form',
            self::Document => 'Document',
        };
    }

    public function getLabel(): string
    {
        return $this->label();
    }
}
