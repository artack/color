<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use Artack\Color\Exception\InvalidArgumentException;

final readonly class CMYK extends Color
{
    public function __construct(
        public float $cyan,
        public float $magenta,
        public float $yellow,
        public float $key,
    ) {
        match (true) {
            (int) floor($cyan) < 0 || (int) ceil($cyan) > 100 => throw new InvalidArgumentException(sprintf('Given cyan value %f must be between %d and %d >> [%2$d, %3$d]', $cyan, 0, 100)),
            (int) floor($magenta) < 0 || (int) ceil($magenta) > 100 => throw new InvalidArgumentException(sprintf('Given magenta value %f must be between %d and %d >> [%2$d, %3$d]', $magenta, 0, 100)),
            (int) floor($yellow) < 0 || (int) ceil($yellow) > 100 => throw new InvalidArgumentException(sprintf('Given yellow value %f must be between %d and %d >> [%2$d, %3$d]', $yellow, 0, 100)),
            (int) floor($key) < 0 || (int) ceil($key) > 100 => throw new InvalidArgumentException(sprintf('Given key value %f must be between %d and %d >> [%2$d, %3$d]', $key, 0, 100)),
            default => null,
        };
    }

    public function getCyan(): float
    {
        return $this->cyan;
    }

    public function getMagenta(): float
    {
        return $this->magenta;
    }

    public function getYellow(): float
    {
        return $this->yellow;
    }

    public function getKey(): float
    {
        return $this->key;
    }
}
