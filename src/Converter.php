<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Color\Color;
use Artack\Color\Converter\Convertible;

class Converter
{
    /** @var Convertible[] */
    private $converters = [];

    /**
     * @param Convertible[] $converters
     */
    public function __construct(array $converters)
    {
        foreach ($converters as $converter) {
            $this->addConverter($converter);
        }
    }

    private function addConverter(Convertible $converter)
    {
        $this->converters[] = $converter;
    }

    public function convert(Color $color, string $fqcn): Color
    {
        foreach ($this->getConverterChain(get_class($color), $fqcn) as $converter) {
            $color = $converter->convert($color);
        }

        return $color;
    }

    /**
     * @param string $fqcnFrom
     * @param string $fqcnTo
     *
     * @return Convertible[]
     */
    private function getConverterChain(string $fqcnFrom, string $fqcnTo): array
    {
        /** @var Convertible[] $converters */
        $converters = [];

        do {
            $converter = $this->getConverterTo($fqcnTo);
            $fqcnTo = $converter::supportsFrom();

            $converters[] = $converter;
        } while ($converter::supportsFrom() !== $fqcnFrom);

        return array_reverse($converters);
    }

    private function getConverterTo(string $fqcn): Convertible
    {
        foreach ($this->converters as $converter) {
            if ($converter::supportsTo() === $fqcn) {
                return $converter;
            }
        }

        throw new \RuntimeException('no converter found getConverterTo');
    }
}
