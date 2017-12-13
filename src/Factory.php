<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Color\HEX;
use Artack\Color\Color\HSV;
use Artack\Color\Color\RGB;
use Artack\Color\Converter\Convertible;
use Artack\Color\Converter\HEXToRGBConverter;
use Artack\Color\Converter\HSVToRGBConverter;
use Artack\Color\Converter\RGBToHEXConverter;
use Artack\Color\Converter\RGBToHSVConverter;
use Artack\Color\Transition\HSVTransition;
use Artack\Color\Transition\RGBTransition;
use Artack\Color\Transition\TransitionInterface;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;

class Factory
{
    const GRAPH_EDGE_KEY_CONVERTER = 'converter';

    /**
     * @return Convertible[]
     */
    public static function getConverters(): array
    {
        return [
            new RGBToHSVConverter(),
            new HSVToRGBConverter(),
            new RGBToHEXConverter(),
            new HEXToRGBConverter(),
        ];
    }

    public static function getColors(): array
    {
        return [
            RGB::class,
            HSV::class,
            HEX::class,
        ];
    }

    /**
     * @return TransitionInterface[]
     */
    public static function getTransitions(): array
    {
        return [
            new RGBTransition(),
            new HSVTransition(),
        ];
    }

    public static function getConverterGraph(): Graph
    {
        $graph = new Graph();

        /** @var Vertex[] $vertices */
        $vertices = [];

        foreach (self::getColors() as $color) {
            $vertices[$color] = $graph->createVertex($color);
        }

        foreach (self::getConverters() as $converter) {
            $vertices[$converter::supportsFrom()]->createEdgeTo($vertices[$converter::supportsTo()])->setAttribute(self::GRAPH_EDGE_KEY_CONVERTER, $converter);
        }

        return $graph;
    }
}
