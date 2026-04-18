<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Color\Color;

final readonly class Converter
{
    public function __construct(
        private ConverterGraph $converterGraph,
    ) {
    }

    public function convert(Color $color, string $fqcn): Color
    {
        if ($color::class === $fqcn) {
            return clone $color;
        }

        foreach ($this->converterGraph->getConverterChain($color::class, $fqcn) as $converter) {
            $color = $converter->convert($color);
        }

        return $color;
    }
}
