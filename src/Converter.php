<?php

declare(strict_types=1);

namespace Artack\Color;

class Converter
{
    public static function toHSV(Color $color): HSV
    {
        if ($color instanceof HSV) {
            return clone $color;
        }

        if ($color instanceof RGB) {
            return self::RGBtoHSV($color);
        }
    }

    public static function toRGB(Color $color): RGB
    {
        if ($color instanceof RGB) {
            return clone $color;
        }

        if ($color instanceof HSV) {
            return self::HSVtoRGB($color);
        }
    }

    public static function toHEX(Color $color): string
    {
        if (!$color instanceof RGB) {
            $color = self::toRGB($color);
        }

        return sprintf('%02x%02x%02x', $color->getRed(), $color->getGreen(), $color->getBlue());
    }

    public static function HSVtoRGB(HSV $HSV): RGB
    {
        $h = $HSV->getHue();
        $s = $HSV->getSaturation() / 100;
        $v = $HSV->getValue() / 100;

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
        }

        return new RGB((int) round($r * 255), (int) round($g * 255), (int) round($b * 255));
    }

    public static function RGBtoHSV(RGB $RGB): HSV
    {
        $red = $RGB->getRed() / 255;
        $green = $RGB->getGreen() / 255;
        $blue = $RGB->getBlue() / 255;

        $cMax = max($red, $green, $blue);
        $cMin = min($red, $green, $blue);
        $cDelta = $cMax - $cMin;

        $hue = $cMax;

        if ($cDelta == 0) {
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
        $saturation = $cMax === 0 ? 0 : $cDelta / $cMax;

        return new HSV($hue, $saturation * 100, $cMax * 100);
    }
}
