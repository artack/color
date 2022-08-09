<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;
use Artack\Color\Color\HEX;
use Artack\Color\Color\RGB;

use const STR_PAD_LEFT;

use Webmozart\Assert\Assert;

class RGBToHEXConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        /* @var RGB $color */
        Assert::isInstanceOf($color, RGB::class, sprintf('color should be an instance of [%s]', RGB::class));

        $red = dechex($color->getRed());
        $green = dechex($color->getGreen());
        $blue = dechex($color->getBlue());

        $red = str_pad($red, 2, '0', STR_PAD_LEFT);
        $green = str_pad($green, 2, '0', STR_PAD_LEFT);
        $blue = str_pad($blue, 2, '0', STR_PAD_LEFT);

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
