<?php

namespace App\Enums;

enum JenisKelamin: string
{
    case LakiLaki = 'Laki-Laki';
    case Perempuan = 'Perempuan';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
