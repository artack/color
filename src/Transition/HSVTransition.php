<?php

declare(strict_types=1);

namespace Artack\Color\Transition;

use Artack\Color\Color\Color;
use Artack\Color\Color\HSV;
use Artack\Color\Color\RGB;

class HSVTransition implements TransitionInterface
{
    public static function interpolate(Color $startColor, Color $endColor, float $value, float $max): Color
    {
        $step = $value / $max;

        $hue = $startColor->getHue() + ($endColor->getHue() - $startColor->getHue()) * $step;
        $saturation = $startColor->getSaturation() + ($endColor->getSaturation() - $startColor->getSaturation()) * $step;
        $value = $startColor->getValue() + ($endColor->getValue() - $startColor->getValue()) * $step;

        return new HSV((int) round($hue), $saturation, $value);
    }
}
