<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;
use Artack\Color\Color\HSV;
use Artack\Color\Color\RGB;
use Webmozart\Assert\Assert;

class RGBToHSVConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        /* @var RGB $color */
        Assert::isInstanceOf($color, RGB::class, sprintf('color should be an instance of [%s]', RGB::class));

        $red = $color->getRed() / 255;
        $green = $color->getGreen() / 255;
        $blue = $color->getBlue() / 255;

        $cMax = max($red, $green, $blue);
        $cMin = min($red, $green, $blue);
        $cDelta = $cMax - $cMin;

        $hue = $cMax;

        if (0 == $cDelta) {
            $hue = 0;
        } elseif ($cMax === $red) {
            $hue = ($green - $blue) / $cDelta;
        } elseif ($cMax === $green) {
            $hue = ($blue - $red) / $cDelta + 2;
        } elseif ($cMax === $blue) {
            $hue = ($red - $green) / $cDelta + 4;
        }

        $hue = (int) round($hue * 60);
        $hue = $hue < 0 ? $hue + 360 : $hue;
        $saturation = 0 === $cMax ? 0 : $cDelta / $cMax;

        $saturation = $saturation > 1 || $saturation < 0 ? 1 : $saturation;
        $cMax = $cMax > 1 || $cMax < 0 ? 1 : $cMax;

        return new HSV($hue, $saturation * 100, $cMax * 100);
    }

    public static function supportsFrom(): string
    {
        return RGB::class;
    }

    public static function supportsTo(): string
    {
        return HSV::class;
    }
}
