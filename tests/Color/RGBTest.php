<?php

namespace Artack\Color\Color;

use PHPUnit\Framework\TestCase;

class RGBTest extends TestCase
{

    public function testCanBeCreated()
    {
        $red = 85;
        $green = 170;
        $blue = 255;

        $RGB = new RGB($red, $green, $blue);

        $this->assertInstanceOf(RGB::class, $RGB);
        $this->assertInstanceOf(Color::class, $RGB);

        $this->assertEquals($red, $RGB->getRed());
        $this->assertEquals($green, $RGB->getGreen());
        $this->assertEquals($blue, $RGB->getBlue());
    }

}