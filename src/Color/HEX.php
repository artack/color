<?php

declare(strict_types=1);

namespace Artack\Color\Color;

class HEX extends Color
{
    private $red;
    private $green;
    private $blue;

    public function __construct(string $red, string $green, string $blue)
    {
        $pattern = '/^[0-9a-f]{1,2}$/i';

        if (!preg_match($pattern, $red)) {
            throw new \InvalidArgumentException(sprintf('Given red value %s need so to be a valid 2 character hex string', $red));
        }
        if (!preg_match($pattern, $green)) {
            throw new \InvalidArgumentException(sprintf('Given red value %s need so to be a valid 2 character hex string', $green));
        }
        if (!preg_match($pattern, $blue)) {
            throw new \InvalidArgumentException(sprintf('Given red value %s need so to be a valid 2 character hex string', $blue));
        }

        $this->red = strtolower($red);
        $this->green = strtolower($green);
        $this->blue = strtolower($blue);
    }

    public static function createFromHexString(string $hex): self
    {
        $colorHexParts = str_split(trim($hex, '#'), 2);

        return new self($colorHexParts[0], $colorHexParts[1], $colorHexParts[2]);
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
