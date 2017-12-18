<?php

declare(strict_types=1);

namespace Artack\Color\Converter;

use Artack\Color\Color\Color;

interface ConverterInterface
{
    public function convert(Color $color): Color;

    public static function supportsFrom(): string;

    public static function supportsTo(): string;
}
