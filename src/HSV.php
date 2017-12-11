<?php

declare(strict_types=1);

namespace Artack\Color;

use Webmozart\Assert\Assert;

class HSV extends Color
{

    private $hue;
    private $saturation;
    private $value;

    public function __construct(int $hue, float $saturation, float $value)
    {
        Assert::range($hue, 0, 360);
        Assert::range($saturation, 0, 100);
        Assert::range($value, 0, 100);

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
