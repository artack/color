<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;
use Artack\Color\Color\HEX;
use Artack\Color\Color\RGB;
use Webmozart\Assert\Assert;

class HEXToRGBConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        /* @var HEX $color */
        Assert::isInstanceOf($color, HEX::class, sprintf('color should be an instance of [%s]', HEX::class));

        $red = (int) hexdec($color->getRed());
        $green = (int) hexdec($color->getGreen());
        $blue = (int) hexdec($color->getBlue());

        return new RGB($red, $green, $blue);
    }

    public static function supportsFrom(): string
    {
        return HEX::class;
    }

    public static function supportsTo(): string
    {
        return RGB::class;
    }
}
