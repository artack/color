<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;
use Artack\Color\Color\HSL;
use Artack\Color\Color\RGB;
use Artack\Color\Exception\InvalidArgumentException;

final class RGBToHSLConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        if (!$color instanceof RGB) {
            throw new InvalidArgumentException(sprintf('color should be an instance of [%s]', RGB::class));
        }

        $red = $color->red / 255;
        $green = $color->green / 255;
        $blue = $color->blue / 255;

        $cMax = max($red, $green, $blue);
        $cMin = min($red, $green, $blue);
        $cDelta = $cMax - $cMin;

        $hue = match (true) {
            0 == $cDelta => 0.0,
            $cMax === $red => ($green - $blue) / $cDelta,
            $cMax === $green => ($blue - $red) / $cDelta + 2,
            $cMax === $blue => ($red - $green) / $cDelta + 4,
            default => $cMax,
        };

        $hue = (int) round($hue * 60);
        $hue = $hue < 0 ? $hue + 360 : $hue;

        $lightness = ($cMax + $cMin) / 2;
        $saturation = 0 == $cDelta ? 0.0 : $cDelta / (1 - abs(2 * $lightness - 1));

        $saturation = $saturation > 1 || $saturation < 0 ? 1 : $saturation;
        $lightness = $lightness > 1 || $lightness < 0 ? 1 : $lightness;

        return new HSL($hue, $saturation * 100, $lightness * 100);
    }

    public static function supportsFrom(): string
    {
        return RGB::class;
    }

    public static function supportsTo(): string
    {
        return HSL::class;
    }
}
