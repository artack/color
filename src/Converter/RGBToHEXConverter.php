<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;
use Artack\Color\Color\HEX;
use Artack\Color\Color\RGB;
use Artack\Color\Exception\InvalidArgumentException;

final class RGBToHEXConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        if (!$color instanceof RGB) {
            throw new InvalidArgumentException(sprintf('color should be an instance of [%s]', RGB::class));
        }

        return new HEX(
            str_pad(dechex($color->red), 2, '0', STR_PAD_LEFT),
            str_pad(dechex($color->green), 2, '0', STR_PAD_LEFT),
            str_pad(dechex($color->blue), 2, '0', STR_PAD_LEFT),
        );
    }

    public static function supportsFrom(): string
    {
        return RGB::class;
    }

    public static function supportsTo(): string
    {
        return HEX::class;
    }
}
