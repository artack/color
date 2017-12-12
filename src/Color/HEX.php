<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use Webmozart\Assert\Assert;

class HEX extends Color
{

    private $red;
    private $green;
    private $blue;

    public function __construct(string $red, string $green, string $blue)
    {
        Assert::range(hexdec($red), 0, 255);
        Assert::range(hexdec($green), 0, 255);
        Assert::range(hexdec($blue), 0, 255);

        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    public function __toString()
    {
        return sprintf('%02x%02x%02x', hexdec($this->red), hexdec($this->green), hexdec($this->blue));
    }

    public function getRed(): string
    {
        return $this->red;
    }

    public function getGreen(): string
    {
        return $this->green;
    }

    public function getBlue(): string
    {
        return $this->blue;
    }

}
