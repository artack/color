<?php

declare(strict_types=1);

namespace Artack\Color;

class Helper
{

    public static function eightBitToDecimal(int $eightBit): float
    {
        return $eightBit / 255;
    }

}