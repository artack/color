<?php

namespace Artack\Color\Color;

use PHPUnit\Framework\TestCase;

class HSVTest extends TestCase
{
    public function testCanBeCreated()
    {
        $hue = 180;
        $saturation = 50;
        $value = 50;

        $HSV = new HSV($hue, $saturation, $value);

        $this->assertInstanceOf(HSV::class, $HSV);
        $this->assertInstanceOf(Color::class, $HSV);

        $this->assertEquals($hue, $HSV->getHue());
        $this->assertEquals($saturation, $HSV->getSaturation());
        $this->assertEquals($value, $HSV->getValue());
    }
}