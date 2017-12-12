<?php

declare(strict_types=1);

namespace Artack\Color\Transition;

use Artack\Color\Color\Color;
use Artack\Color\Color\RGB;
use Webmozart\Assert\Assert;

class RGBTransition implements TransitionInterface
{
    public function interpolate(Color $startColor, Color $endColor, float $value, float $max): Color
    {
        /* @var RGB $startColor */
        Assert::isInstanceOf($startColor, RGB::class, sprintf('startColor needs to be an instance of [%s]', RGB::class));

        /* @var RGB $endColor */
        Assert::isInstanceOf($endColor, RGB::class, sprintf('endColor needs to be an instance of [%s]', RGB::class));

        $step = $value / $max;

        $red = $startColor->getRed() + ($endColor->getRed() - $startColor->getRed()) * $step;
        $green = $startColor->getGreen() + ($endColor->getGreen() - $startColor->getGreen()) * $step;
        $blue = $startColor->getBlue() + ($endColor->getBlue() - $startColor->getBlue()) * $step;

        return new RGB((int) round($red), (int) round($green), (int) round($blue));
    }

    public function supports(string $fqcn): bool
    {
        return RGB::class === $fqcn;
    }
}
