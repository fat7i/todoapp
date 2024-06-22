<?php

namespace App\Enum;

enum StatusEnum: string
{
    case STATUS_PENDING = 'pending';
    case STATUS_COMPLETED = 'completed';

    public static function toArray(): array
    {
        return [
            self::STATUS_PENDING->value,
            self::STATUS_COMPLETED->value,
        ];
    }
}