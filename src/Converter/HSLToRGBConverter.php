<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;
use Artack\Color\Color\HSL;
use Artack\Color\Color\RGB;
use Artack\Color\Exception\InvalidArgumentException;
use RuntimeException;

final class HSLToRGBConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        if (!$color instanceof HSL) {
            throw new InvalidArgumentException(sprintf('color should be an instance of [%s]', HSL::class));
        }

        $hue = $color->hue;
        $saturation = $color->saturation / 100;
        $lightness = $color->lightness / 100;

        $c = (1 - abs(2 * $lightness - 1)) * $saturation;
        $x = $c * (1 - abs(fmod($hue / 60, 2) - 1));
        $m = $lightness - $c / 2;

        [$red, $green, $blue] = match ((int) floor($hue / 60)) {
            0 => [$c, $x, 0],
            1 => [$x, $c, 0],
            2 => [0, $c, $x],
            3 => [0, $x, $c],
            4 => [$x, 0, $c],
            5 => [$c, 0, $x],
            default => throw new RuntimeException(),
        };

        return new RGB(
            (int) round(($red + $m) * 255),
            (int) round(($green + $m) * 255),
            (int) round(($blue + $m) * 255),
        );
    }

    public static function supportsFrom(): string
    {
        return HSL::class;
    }

    public static function supportsTo(): string
    {
        return RGB::class;
    }
}
