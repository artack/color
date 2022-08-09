<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;
use Artack\Color\Color\HSV;
use Artack\Color\Color\RGB;
use RuntimeException;
use Webmozart\Assert\Assert;

class HSVToRGBConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        /* @var HSV $color */
        Assert::isInstanceOf($color, HSV::class, sprintf('color should be an instance of [%s]', HSV::class));

        $h = $color->getHue();
        $s = $color->getSaturation() / 100;
        $v = $color->getValue() / 100;

        $hF = floor($h / 60);
        $f = $h / 60 - $hF;

        $p = $v * (1 - $s);
        $q = $v * (1 - $s * $f);
        $t = $v * (1 - $s * (1 - $f));

        switch ($hF) {
            case 0:
                $r = $v;
                $g = $t;
                $b = $p;
                break;
            case 1:
                $r = $q;
                $g = $v;
                $b = $p;
                break;
            case 2:
                $r = $p;
                $g = $v;
                $b = $t;
                break;
            case 3:
                $r = $p;
                $g = $q;
                $b = $v;
                break;
            case 4:
                $r = $t;
                $g = $p;
                $b = $v;
                break;
            case 5:
                $r = $v;
                $g = $p;
                $b = $q;
                break;
            default:
                throw new RuntimeException();
        }

        return new RGB((int) round($r * 255), (int) round($g * 255), (int) round($b * 255));
    }

    public static function supportsFrom(): string
    {
        return HSV::class;
    }

    public static function supportsTo(): string
    {
        return RGB::class;
    }
}
