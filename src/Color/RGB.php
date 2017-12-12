<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use Webmozart\Assert\Assert;

class RGB extends Color
{
    private $red;
    private $green;
    private $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        Assert::range($red, 0, 255);
        Assert::range($green, 0, 255);
        Assert::range($blue, 0, 255);

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
