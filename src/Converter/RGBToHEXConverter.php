<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;
use Artack\Color\Color\HEX;
use Artack\Color\Color\RGB;
use Webmozart\Assert\Assert;

class RGBToHEXConverter implements Convertible
{
    public function convert(Color $color): Color
    {
        /* @var RGB $color */
        Assert::isInstanceOf($color, RGB::class, sprintf('color should be an instance of [%s]', RGB::class));

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
