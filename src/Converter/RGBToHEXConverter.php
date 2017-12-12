<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;
use Artack\Color\Color\HEX;
use Artack\Color\Color\RGB;

class RGBToHEXConverter implements Convertible
{
    public function convert(Color $color): Color
    {
        if (!$color instanceof RGB) {
            throw new \RuntimeException('color is not RGB');
        }

        $red = dechex($color->getRed());
        $green = dechex($color->getGreen());
        $blue = dechex($color->getBlue());

        return new HEX($red, $green, $blue);
    }

    public static function supportsFrom(): string
    {
        return RGB::class;
    }

    public static function supportsTo(): string
    {
        return HEX::class;
    }
}