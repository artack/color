<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use Artack\Color\Exception\InvalidArgumentException;

class CMYK extends Color
{
    private float $cyan;
    private float $magenta;
    private float $yellow;
    private float $key;

    public function __construct(float $cyan, float $magenta, float $yellow, float $key)
    {
        if (((int) floor($cyan)) < 0 || ((int) ceil($cyan)) > 100) {
            throw new InvalidArgumentException(sprintf('Given cyan value %f must be between %d and %d >> [%2$d, %3$d]', $cyan, 0, 100));
        }

        if (((int) floor($magenta)) < 0 || ((int) ceil($magenta)) > 100) {
            throw new InvalidArgumentException(sprintf('Given magenta value %f must be between %d and %d >> [%2$d, %3$d]', $magenta, 0, 100));
        }

        if (((int) floor($yellow)) < 0 || ((int) ceil($yellow)) > 100) {
            throw new InvalidArgumentException(sprintf('Given yellow value %f must be between %d and %d >> [%2$d, %3$d]', $yellow, 0, 100));
        }

        if (((int) floor($key)) < 0 || ((int) ceil($key)) > 100) {
            throw new InvalidArgumentException(sprintf('Given key value %f must be between %d and %d >> [%2$d, %3$d]', $key, 0, 100));
        }

        $this->cyan = $cyan;
        $this->magenta = $magenta;
        $this->yellow = $yellow;
        $this->key = $key;
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
