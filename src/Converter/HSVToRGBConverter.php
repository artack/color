<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;
use Artack\Color\Color\HSV;
use Artack\Color\Color\RGB;
use Artack\Color\Exception\InvalidArgumentException;
use RuntimeException;

final class HSVToRGBConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        if (!$color instanceof HSV) {
            throw new InvalidArgumentException(sprintf('color should be an instance of [%s]', HSV::class));
        }

        $h = $color->hue;
        $s = $color->saturation / 100;
        $v = $color->value / 100;

        $hF = (int) floor($h / 60);
        $f = $h / 60 - $hF;

        $p = $v * (1 - $s);
        $q = $v * (1 - $s * $f);
        $t = $v * (1 - $s * (1 - $f));

        [$r, $g, $b] = match ($hF) {
            0 => [$v, $t, $p],
            1 => [$q, $v, $p],
            2 => [$p, $v, $t],
            3 => [$p, $q, $v],
            4 => [$t, $p, $v],
            5 => [$v, $p, $q],
            default => throw new RuntimeException(),
        };

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
