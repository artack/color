<?php

declare(strict_types=1);

namespace Artack\Color\Transition;

use Artack\Color\Color\Color;
use Artack\Color\Color\RGB;

class RGBTransition implements TransitionInterface
{
    public static function interpolate(Color $startColor, Color $endColor, float $value, float $max): Color
    {
        $step = $value / $max;

        $red = $startColor->getRed() + ($endColor->getRed() - $startColor->getRed()) * $step;
        $green = $startColor->getGreen() + ($endColor->getGreen() - $startColor->getGreen()) * $step;
        $blue = $startColor->getBlue() + ($endColor->getBlue() - $startColor->getBlue()) * $step;

        return new RGB((int) round($red), (int) round($green), (int) round($blue));
    }
}
