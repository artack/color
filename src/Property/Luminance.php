<?php

declare(strict_types=1);

namespace Artack\Color\Property;

use Artack\Color\Color\RGB;
use Artack\Color\Helper;

class Luminance
{
    public static function getLuminance(RGB $RGB)
    {
        $red = RGBChannel::linearize(Helper::eightBitToDecimal($RGB->getRed()));
        $green = RGBChannel::linearize(Helper::eightBitToDecimal($RGB->getGreen()));
        $blue = RGBChannel::linearize(Helper::eightBitToDecimal($RGB->getBlue()));

        return 0.2126 * $red + 0.7152 * $green + 0.0722 * $blue;
    }
}
