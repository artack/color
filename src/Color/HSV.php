<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use Artack\Color\Exception\InvalidArgumentException;

class HSV extends Color
{
    private int $hue;
    private float $saturation;
    private float $value;

    public function __construct(int $hue, float $saturation, float $value)
    {
        if ($hue < 0 || $hue > 360) {
            throw new InvalidArgumentException(sprintf('Given hue value %d is expected to be between %d and %d >> [%2$d,%3$d]', $hue, 0, 360));
        }

        if (((int) floor($saturation)) < 0 || ((int) ceil($saturation)) > 100) {
            throw new InvalidArgumentException(sprintf('Given saturation value %f must be between %d and %d >> [%2$d, %3$d]', $saturation, 0, 100));
        }

        if (((int) floor($value)) < 0 || ((int) ceil($value)) > 100) {
            throw new InvalidArgumentException(sprintf('Given value value %f must be between %d and %d >> [%2$d, %3$d]', $value, 0, 100));
        }

        $this->hue = $hue;
        $this->saturation = $saturation;
        $this->value = $value;
    }

    public function getHue(): int
    {
        return $this->hue;
    }

    public function getSaturation(): float
    {
        return $this->saturation;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
