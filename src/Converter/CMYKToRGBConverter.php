<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\CMYK;
use Artack\Color\Color\Color;
use Artack\Color\Color\RGB;
use Webmozart\Assert\Assert;

class CMYKToRGBConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        /* @var CMYK $color */
        Assert::isInstanceOf($color, CMYK::class, sprintf('color should be an instance of [%s]', CMYK::class));

        $cyan = $color->getCyan() / 100;
        $magenta = $color->getMagenta() / 100;
        $yellow = $color->getYellow() / 100;
        $key = $color->getKey() / 100;

        $red = 1 - min(1, $cyan * (1 - $key) + $key);
        $green = 1 - min(1, $magenta * (1 - $key) + $key);
        $blue = 1 - min(1, $yellow * (1 - $key) + $key);

        $red *= 255;
        $green *= 255;
        $blue *= 255;

        return new RGB((int) round($red), (int) round($green), (int) round($blue));
    }

    public static function supportsFrom(): string
    {
        return CMYK::class;
    }

    public static function supportsTo(): string
    {
        return RGB::class;
    }
}
