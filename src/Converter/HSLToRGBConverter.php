<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;
use Artack\Color\Color\HSL;
use Artack\Color\Color\RGB;
use RuntimeException;
use Webmozart\Assert\Assert;

class HSLToRGBConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        /* @var HSL $color */
        Assert::isInstanceOf($color, HSL::class, sprintf('color should be an instance of [%s]', HSL::class));

        $hue = $color->getHue();
        $saturation = $color->getSaturation() / 100;
        $lightness = $color->getLightness() / 100;

        $c = (1 - abs(2 * $lightness - 1)) * $saturation; // 0.5
        $x = $c * (1 - abs(fmod($hue / 60, 2) - 1));
        $m = $lightness - $c / 2; // 0.25

        switch (floor($hue / 60)) {
            case 0:
                $red = $c;
                $green = $x;
                $blue = 0;
                break;
            case 1:
                $red = $x;
                $green = $c;
                $blue = 0;
                break;
            case 2:
                $red = 0;
                $green = $c;
                $blue = $x;
                break;
            case 3:
                $red = 0;
                $green = $x;
                $blue = $c;
                break;
            case 4:
                $red = $x;  //  >> 64 ???
                $green = 0; // >> 64
                $blue = $c; // 0.5 >> (0.25+0.5)*255 >> 191.25 >> 191 OK
                break;
            case 5:
                $red = $c;
                $green = 0;
                $blue = $x;
                break;
            default:
                throw new RuntimeException();
        }

        return new RGB((int) round(($red + $m) * 255), (int) round(($green + $m) * 255), (int) round(($blue + $m) * 255));
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
