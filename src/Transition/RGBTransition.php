<?php

declare(strict_types=1);

namespace Artack\Color\Transition;

use Artack\Color\Color\Color;
use Artack\Color\Color\RGB;
use Artack\Color\Exception\InvalidArgumentException;

final class RGBTransition implements TransitionInterface
{
    public function interpolate(Color $startColor, Color $endColor, float $value, float $max): Color
    {
        if (!$startColor instanceof RGB) {
            throw new InvalidArgumentException(sprintf('startColor needs to be an instance of [%s]', RGB::class));
        }

        if (!$endColor instanceof RGB) {
            throw new InvalidArgumentException(sprintf('endColor needs to be an instance of [%s]', RGB::class));
        }

        $step = $value / $max;

        $red = $startColor->red + ($endColor->red - $startColor->red) * $step;
        $green = $startColor->green + ($endColor->green - $startColor->green) * $step;
        $blue = $startColor->blue + ($endColor->blue - $startColor->blue) * $step;

        return new RGB((int) round($red), (int) round($green), (int) round($blue));
    }

    public function supports(string $fqcn): bool
    {
        return RGB::class === $fqcn;
    }
}
