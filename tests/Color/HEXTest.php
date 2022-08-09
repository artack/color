<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use Artack\Color\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class HEXTest extends TestCase
{
    /**
     * @dataProvider correctInputProvider
     */
    public function testHEXCanBeCreated($red, $green, $blue)
    {
        $HEX = new HEX($red, $green, $blue);

        $this->assertInstanceOf(HEX::class, $HEX);
        $this->assertInstanceOf(Color::class, $HEX);

        $this->assertEquals($red, $HEX->getRed());
        $this->assertEquals($green, $HEX->getGreen());
        $this->assertEquals($blue, $HEX->getBlue());
    }

    /**
     * @dataProvider wrongInputProvider
     */
    public function testHEXCanNotBeCreated($red, $green, $blue)
    {
        $this->expectException(InvalidArgumentException::class);
        new HEX($red, $green, $blue);
    }

    public function correctInputProvider(): array
    {
        return [
            ['00', '00', '00'],
            ['88', '88', '88'],
            ['ff', 'ff', 'ff'],
        ];
    }

    public function wrongInputProvider(): array
    {
        return [
            ['000', '00', '00'],
            ['0ff', '00', '00'],
            ['1ff', '00', '00'],

            ['00', '000', '00'],
            ['00', '0ff', '00'],
            ['00', '1ff', '00'],

            ['00', '00', '000'],
            ['00', '00', '0ff'],
            ['00', '00', '1ff'],

            ['fg', '00', '00'],
            ['00', 'fg', '00'],
            ['00', '00', 'fg'],
        ];
    }
}
