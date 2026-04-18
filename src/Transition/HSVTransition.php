<?php

declare(strict_types=1);

namespace Artack\Color\Transition;

use Artack\Color\Color\Color;
use Artack\Color\Color\HSV;
use Artack\Color\Exception\InvalidArgumentException;

final class HSVTransition implements TransitionInterface
{
    public function interpolate(Color $startColor, Color $endColor, float $value, float $max): Color
    {
        if (!$startColor instanceof HSV) {
            throw new InvalidArgumentException(sprintf('startColor needs to be an instance of [%s]', HSV::class));
        }

        if (!$endColor instanceof HSV) {
            throw new InvalidArgumentException(sprintf('endColor needs to be an instance of [%s]', HSV::class));
        }

        $step = $value / $max;

        $hue = $startColor->hue + ($endColor->hue - $startColor->hue) * $step;
        $saturation = $startColor->saturation + ($endColor->saturation - $startColor->saturation) * $step;
        $value = $startColor->value + ($endColor->value - $startColor->value) * $step;

        return new HSV((int) round($hue), $saturation, $value);
    }

    public function supports(string $fqcn): bool
    {
        return HSV::class === $fqcn;
    }
}
