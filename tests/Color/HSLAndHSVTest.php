<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use Artack\Color\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class HSLAndHSVTest extends TestCase
{
    /**
     * @dataProvider correctInputProvider
     */
    public function testHSLCanBeCreated($hue, $saturation, $lightness)
    {
        $HSL = new HSL($hue, $saturation, $lightness);

        $this->assertInstanceOf(HSL::class, $HSL);
        $this->assertInstanceOf(Color::class, $HSL);

        $this->assertEquals($hue, $HSL->getHue());
        $this->assertEquals($saturation, $HSL->getSaturation());
        $this->assertEquals($lightness, $HSL->getLightness());
    }

    /**
     * @dataProvider wrongInputProvider
     */
    public function testHSLCanNotBeCreated($hue, $saturation, $lightness)
    {
        $this->expectException(\InvalidArgumentException::class);
        new HSL($hue, $saturation, $lightness);
    }

    /**
     * @dataProvider correctInputProvider
     */
    public function testHSVCanBeCreated($hue, $saturation, $value)
    {
        $HSL = new HSV($hue, $saturation, $value);

        $this->assertInstanceOf(HSV::class, $HSL);
        $this->assertInstanceOf(Color::class, $HSL);

        $this->assertEquals($hue, $HSL->getHue());
        $this->assertEquals($saturation, $HSL->getSaturation());
        $this->assertEquals($value, $HSL->getValue());
    }

    /**
     * @dataProvider wrongInputProvider
     */
    public function testHSVCanNotBeCreated($hue, $saturation, $lightness)
    {
        $this->expectException(InvalidArgumentException::class);
        new HSV($hue, $saturation, $lightness);
    }

    public function correctInputProvider(): array
    {
        return [
            [180,  50.0,  50.0],
            [360, 50, 50],

            [0,  50.0,  50.0],
            [359,  50.0,  50.0],

            [180,   0.0,  50.0],
            [180, 100.0,  50.0],

            [180,  50.0,   0.0],
            [180,  50.0, 100.0],
        ];
    }

    public function wrongInputProvider(): array
    {
        return [
            [-1, 50, 50],

            [180, -0.01, 50],
            [180, 100.01, 50],

            [180, 50, -0.01],
            [180, 50, 100.01],
        ];
    }
}
