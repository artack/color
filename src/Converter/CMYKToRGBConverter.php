<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\CMYK;
use Artack\Color\Color\Color;
use Artack\Color\Color\RGB;
use Artack\Color\Exception\InvalidArgumentException;

final class CMYKToRGBConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        if (!$color instanceof CMYK) {
            throw new InvalidArgumentException(sprintf('color should be an instance of [%s]', CMYK::class));
        }

        $cyan = $color->cyan / 100;
        $magenta = $color->magenta / 100;
        $yellow = $color->yellow / 100;
        $key = $color->key / 100;

        $red = (1 - min(1, $cyan * (1 - $key) + $key)) * 255;
        $green = (1 - min(1, $magenta * (1 - $key) + $key)) * 255;
        $blue = (1 - min(1, $yellow * (1 - $key) + $key)) * 255;

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
