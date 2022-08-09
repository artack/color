<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Color\Color;

use function get_class;

class Converter
{
    private ConverterGraph $converterGraph;

    public function __construct(ConverterGraph $converterGraph)
    {
        $this->converterGraph = $converterGraph;
    }

    public function convert(Color $color, string $fqcn): Color
    {
        if (get_class($color) === $fqcn) {
            return clone $color;
        }

        foreach ($this->converterGraph->getConverterChain(get_class($color), $fqcn) as $converter) {
            $color = $converter->convert($color);
        }

        return $color;
    }
}
