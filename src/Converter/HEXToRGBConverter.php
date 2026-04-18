<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;
use Artack\Color\Color\HEX;
use Artack\Color\Color\RGB;
use Artack\Color\Exception\InvalidArgumentException;

final class HEXToRGBConverter implements ConverterInterface
{
    public function convert(Color $color): Color
    {
        if (!$color instanceof HEX) {
            throw new InvalidArgumentException(sprintf('color should be an instance of [%s]', HEX::class));
        }

        return new RGB(
            (int) hexdec($color->red),
            (int) hexdec($color->green),
            (int) hexdec($color->blue),
        );
    }

    public static function supportsFrom(): string
    {
        return HEX::class;
    }

    public static function supportsTo(): string
    {
        return RGB::class;
    }
}
