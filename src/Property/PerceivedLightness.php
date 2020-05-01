<?php

declare(strict_types=1);

namespace Artack\Color\Property;

class PerceivedLightness
{
    public static function getPerceivedLightness(float $y): float
    {
        if ($y <= (216/24389)) {        // The CIE standard states 0.008856 but 216/24389 is the intent for 0.008856451679036
            return $y * (24389/27);     // The CIE standard states 903.3, but 24389/27 is the intent, making 903.296296296296296
        } else {
            return pow($y, (1/3)) * 116 - 16;
        }
    }
}
