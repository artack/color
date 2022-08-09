<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use Artack\Color\Exception\InvalidArgumentException;

class RGB extends Color
{
    private int $red;
    private int $green;
    private int $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        if ($red < 0 || $red > 255) {
            throw new InvalidArgumentException(sprintf('Given red value %d is expected to be between %d and %d >> [%2$d,%3$d]', $red, 0, 255));
        }

        if ($green < 0 || $green > 255) {
            throw new InvalidArgumentException(sprintf('Given green value %d is expected to be between %d and %d >> [%2$d,%3$d]', $green, 0, 255));
        }

        if ($blue < 0 || $blue > 255) {
            throw new InvalidArgumentException(sprintf('Given blue value %d is expected to be between %d and %d >> [%2$d,%3$d]', $blue, 0, 255));
        }

        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    public function getRed(): int
    {
        return $this->red;
    }

    public function getGreen(): int
    {
        return $this->green;
    }

    public function getBlue(): int
    {
        return $this->blue;
    }
}
