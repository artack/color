<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Converter\Convertible;
use Artack\Color\Converter\HSVToRGBConverter;
use Artack\Color\Converter\RGBToHEXConverter;
use Artack\Color\Converter\RGBToHSVConverter;
use Artack\Color\Transition\HSVTransition;
use Artack\Color\Transition\RGBTransition;
use Artack\Color\Transition\TransitionInterface;

class Factory
{
    /**
     * @return Convertible[]
     */
    public static function getConverters(): array
    {
        return [
            new RGBToHSVConverter(),
            new HSVToRGBConverter(),
            new RGBToHEXConverter(),
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
}
