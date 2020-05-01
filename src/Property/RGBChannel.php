<?php

declare(strict_types=1);

namespace Artack\Color\Property;

class RGBChannel
{
    public static function linearize(float $rgbChannel): float
    {
        if ($rgbChannel <= 0.04045) {
            return $rgbChannel / 12.92;
        } else {
            return pow((($rgbChannel + 0.055) / 1.055),2.4);
        }
    }
}
