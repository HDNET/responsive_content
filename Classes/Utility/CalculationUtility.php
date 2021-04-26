<?php

declare(strict_types=1);

namespace HDNET\ResponsiveContent\Utility;

class CalculationUtility
{
    public const COL_NUMBER = 12;

    public static function getPercentByCols(int $cols): float
    {
        $value = 100 / self::COL_NUMBER * $cols;
        return round($value, 2);
    }
}
