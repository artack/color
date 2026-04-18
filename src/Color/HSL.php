<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use Artack\Color\Exception\InvalidArgumentException;

final readonly class HSL extends Color
{
    public function __construct(
        public int $hue,
        public float $saturation,
        public float $lightness,
    ) {
        match (true) {
            $hue < 0 || $hue > 360 => throw new InvalidArgumentException(sprintf('Given hue value %d is expected to be between %d and %d >> [%2$d,%3$d]', $hue, 0, 360)),
            (int) floor($saturation) < 0 || (int) ceil($saturation) > 100 => throw new InvalidArgumentException(sprintf('Given saturation value %f must be between %d and %d >> [%2$d, %3$d]', $saturation, 0, 100)),
            (int) floor($lightness) < 0 || (int) ceil($lightness) > 100 => throw new InvalidArgumentException(sprintf('Given lightness value %f must be between %d and %d >> [%2$d, %3$d]', $lightness, 0, 100)),
            default => null,
        };
    }

    public function getHue(): int
    {
        return $this->hue;
    }

    public function getSaturation(): float
    {
        return $this->saturation;
    }

    public function getLightness(): float
    {
        return $this->lightness;
    }
}
