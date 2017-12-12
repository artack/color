<?php

declare(strict_types=1);

namespace Artack\Color\Transition;

use Artack\Color\Color\Color;
use Artack\Color\Color\HSV;
use Webmozart\Assert\Assert;

class HSVTransition implements TransitionInterface
{
    public function interpolate(Color $startColor, Color $endColor, float $value, float $max): Color
    {
        /* @var HSV $startColor */
        Assert::isInstanceOf($startColor, HSV::class, sprintf('startColor needs to be an instance of [%s]', HSV::class));

        /* @var HSV $endColor */
        Assert::isInstanceOf($endColor, HSV::class, sprintf('endColor needs to be an instance of [%s]', HSV::class));

        $step = $value / $max;

        $hue = $startColor->getHue() + ($endColor->getHue() - $startColor->getHue()) * $step;
        $saturation = $startColor->getSaturation() + ($endColor->getSaturation() - $startColor->getSaturation()) * $step;
        $value = $startColor->getValue() + ($endColor->getValue() - $startColor->getValue()) * $step;

        return new HSV((int) round($hue), $saturation, $value);
    }

    public function supports(string $fqcn): bool
    {
        return HSV::class === $fqcn;
    }
}
