<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use Artack\Color\Exception\InvalidArgumentException;
use Stringable;

final readonly class HEX extends Color implements Stringable
{
    private const PATTERN = '/^[0-9a-f]{1,2}$/i';

    public function __construct(
        public string $red,
        public string $green,
        public string $blue,
    ) {
        match (true) {
            !preg_match(self::PATTERN, $red) => throw new InvalidArgumentException(sprintf('Given red value %s need so to be a valid 2 character hex string', $red)),
            !preg_match(self::PATTERN, $green) => throw new InvalidArgumentException(sprintf('Given red value %s need so to be a valid 2 character hex string', $green)),
            !preg_match(self::PATTERN, $blue) => throw new InvalidArgumentException(sprintf('Given red value %s need so to be a valid 2 character hex string', $blue)),
            default => null,
        };
    }

    public function __toString(): string
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
