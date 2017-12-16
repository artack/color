<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use PHPUnit\Framework\TestCase;

class RGBTest extends TestCase
{
    /**
     * @dataProvider correctInputProvider
     */
    public function testRGBCanBeCreated($red, $green, $blue)
    {
        $RGB = new RGB($red, $green, $blue);

        $this->assertInstanceOf(RGB::class, $RGB);
        $this->assertInstanceOf(Color::class, $RGB);

        $this->assertEquals($red, $RGB->getRed());
        $this->assertEquals($green, $RGB->getGreen());
        $this->assertEquals($blue, $RGB->getBlue());
    }

    /**
     * @dataProvider wrongInputProvider
     * @expectedException \InvalidArgumentException
     */
    public function testRGBCanNotBeCreated($red, $green, $blue)
    {
        new RGB($red, $green, $blue);
    }

    public function correctInputProvider()
    {
        return [
            [0,   0,   0],
            [128, 128, 128],
            [255, 255, 255],
        ];
    }

    public function wrongInputProvider()
    {
        return [
            [-1,   0,   0],
            [256,   0,   0],

            [0,  -1,   0],
            [0, 256,   0],

            [0,   0,  -1],
            [0,   0, 256],
        ];
    }
}
