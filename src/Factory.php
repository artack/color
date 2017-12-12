<?php

namespace Artack\Color;

use Artack\Color\Converter\HSVToRGBConverter;
use Artack\Color\Converter\RGBToHEXConverter;
use Artack\Color\Converter\RGBToHSVConverter;

class Factory
{
    public static function getConverters(): array
    {
        return [
            new RGBToHSVConverter(),
            new HSVToRGBConverter(),
            new RGBToHEXConverter()
        ];
    }
}
