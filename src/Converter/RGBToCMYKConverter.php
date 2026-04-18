<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\CMYK;
use Artack\Color\Color\Color;
use Artack\Color\Color\RGB;
use Artack\Color\Exception\InvalidArgumentException;

final class RGBToCMYKConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        if (!$color instanceof RGB) {
            throw new InvalidArgumentException(sprintf('color should be an instance of [%s]', RGB::class));
        }

        if (0 === $color->red && 0 === $color->green && 0 === $color->blue) {
            return new CMYK(0, 0, 0, 100);
        }

        $red = $color->red / 255 * 100;
        $green = $color->green / 255 * 100;
        $blue = $color->blue / 255 * 100;

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
