<?php
namespace App\Utils\enums;

enum DateType: string
{
    case BIRTHDAY = 'BIRTHDAY';
    case AWARD = 'AWARD';
    case DISCOVERY = 'DISCOVERY';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
