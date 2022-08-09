<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Color\CMYK;
use Artack\Color\Color\HEX;
use Artack\Color\Color\HSL;
use Artack\Color\Color\HSV;
use Artack\Color\Color\RGB;
use Artack\Color\Converter\CMYKToRGBConverter;
use Artack\Color\Converter\ConverterInterface;
use Artack\Color\Converter\HEXToRGBConverter;
use Artack\Color\Converter\HSLToRGBConverter;
use Artack\Color\Converter\HSVToRGBConverter;
use Artack\Color\Converter\RGBToCMYKConverter;
use Artack\Color\Converter\RGBToHEXConverter;
use Artack\Color\Converter\RGBToHSLConverter;
use Artack\Color\Converter\RGBToHSVConverter;
use Artack\Color\Transition\HSVTransition;
use Artack\Color\Transition\RGBTransition;
use Artack\Color\Transition\TransitionInterface;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;

class Factory
{
    public const GRAPH_EDGE_KEY_CONVERTER = 'converter';

    public static function createConverter(): Converter
    {
        return new Converter(new ConverterGraph(self::getConverterGraph()));
    }

    public static function createTransition(): Transition
    {
        return new Transition(self::getTransitions(), self::createConverter());
    }

    /**
     * @return ConverterInterface[]
     */
    private static function getConverters(): array
    {
        return [
            new RGBToHSVConverter(),
            new HSVToRGBConverter(),
            new RGBToHEXConverter(),
            new HEXToRGBConverter(),
            new CMYKToRGBConverter(),
            new RGBToCMYKConverter(),
            new HSLToRGBConverter(),
            new RGBToHSLConverter(),
        ];
    }

    /**
     * @return array<int, class-string>
     */
    public static function getColors(): array
    {
        return [
            RGB::class,
            HSV::class,
            HSL::class,
            HEX::class,
            CMYK::class,
        ];
    }

    /**
     * @return TransitionInterface[]
     */
    private static function getTransitions(): array
    {
        return [
            new RGBTransition(),
            new HSVTransition(),
        ];
    }

    private static function getConverterGraph(): Graph
    {
        $graph = new Graph();

        /** @var Vertex[] $vertices */
        $vertices = [];

        foreach (self::getColors() as $index => $color) {
            $vertices[$color] = $graph->createVertex($index);
        }

        foreach (self::getConverters() as $converter) {
            $vertices[$converter::supportsFrom()]->createEdgeTo($vertices[$converter::supportsTo()])->setAttribute(self::GRAPH_EDGE_KEY_CONVERTER, $converter);
        }

        return $graph;
    }
}
