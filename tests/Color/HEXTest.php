<?php

namespace Artack\Color\Color;

use PHPUnit\Framework\TestCase;

class HEXTest extends TestCase
{
    public function testCanBeCreated()
    {
        $red = '55';
        $green = 'ff';
        $blue = 'aa';

        $HEX = new HEX($red, $green, $blue);

        $this->assertInstanceOf(HEX::class, $HEX);
        $this->assertInstanceOf(Color::class, $HEX);

        $this->assertEquals($red, $HEX->getRed());
        $this->assertEquals($green, $HEX->getGreen());
        $this->assertEquals($blue, $HEX->getBlue());
    }
}