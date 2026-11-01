<?php

namespace App\Enums;

enum DownloadCategory: string
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
}
