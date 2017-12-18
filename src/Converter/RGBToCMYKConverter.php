<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\CMYK;
use Artack\Color\Color\Color;
use Artack\Color\Color\RGB;
use Webmozart\Assert\Assert;

class RGBToCMYKConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        /* @var RGB $color */
        Assert::isInstanceOf($color, RGB::class, sprintf('color should be an instance of [%s]', RGB::class));

        $red = $color->getRed() / 255 * 100;
        $green = $color->getGreen() / 255 * 100;
        $blue = $color->getBlue() / 255 * 100;

        if (0 === $red && 0 === $green && 0 === $blue) {
            return new CMYK(0, 0, 0, 100);
        }

        $key = 100 - max($red, $green, $blue);
        $cyan = ((100 - $red - $key) / (100 - $key)) * 100;
        $magenta = ((100 - $green - $key) / (100 - $key)) * 100;
        $yellow = ((100 - $blue - $key) / (100 - $key)) * 100;

        return new CMYK($cyan, $magenta, $yellow, $key);
    }

    public static function supportsFrom(): string
    {
        return RGB::class;
    }

    public static function supportsTo(): string
    {
        return CMYK::class;
    }
}
