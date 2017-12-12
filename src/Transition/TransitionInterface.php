<?php

declare(strict_types=1);

namespace Artack\Color\Transition;

use Artack\Color\Color\Color;

interface TransitionInterface
{
    public function interpolate(Color $startColor, Color $endColor, float $value, float $max): Color;

    public function supports(string $fqcn): bool;
}
