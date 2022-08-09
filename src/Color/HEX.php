<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use Artack\Color\Exception\InvalidArgumentException;

class HEX extends Color
{
    private string $red;
    private string $green;
    private string $blue;

    public function __construct(string $red, string $green, string $blue)
    {
        $pattern = '/^[0-9a-f]{1,2}$/i';

        if (!preg_match($pattern, $red)) {
            throw new InvalidArgumentException(sprintf('Given red value %s need so to be a valid 2 character hex string', $red));
        }
        if (!preg_match($pattern, $green)) {
            throw new InvalidArgumentException(sprintf('Given red value %s need so to be a valid 2 character hex string', $green));
        }
        if (!preg_match($pattern, $blue)) {
            throw new InvalidArgumentException(sprintf('Given red value %s need so to be a valid 2 character hex string', $blue));
        }

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
