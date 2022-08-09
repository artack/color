<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Color\HEX;
use Artack\Color\Color\HSV;
use Artack\Color\Color\RGB;
use Artack\Color\Transition\RGBTransition;
use PHPUnit\Framework\TestCase;

class TransitionTest extends TestCase
{
    /** @var Transition */
    private $transition;

    protected function setUp(): void
    {
        $this->transition = Factory::createTransition();
    }

    public function testTransition()
    {
        $this->assertInstanceOf(Transition::class, $this->transition);
    }

    public function testWrongParameterRGBToHEX()
    {
        $this->expectException(\InvalidArgumentException::class);
        $HSV = new HSV(0, 0, 0);
        $RGBTransition = new RGBTransition();

        $RGBTransition->interpolate($HSV, $HSV, 0, 1);
    }

    public function testGetRGBTransition()
    {
        $RGB = new RGB(0, 0, 0);
        $color = $this->transition->interpolate(RGB::class, $RGB, $RGB, 0, 1);

        $this->assertInstanceOf(RGB::class, $color);
    }

    public function testGetRGBTransitionWithHSVColors()
    {
        $HSV = new HSV(0, 0, 0);
        $color = $this->transition->interpolate(RGB::class, $HSV, $HSV, 0, 1);

        $this->assertInstanceOf(RGB::class, $color);
    }

    public function testGetHSVTransitionWithRGBColors()
    {
        $RGB = new RGB(0, 0, 0);
        $color = $this->transition->interpolate(HSV::class, $RGB, $RGB, 0, 1);

        $this->assertInstanceOf(HSV::class, $color);
    }

    public function testGetHSVTransition()
    {
        $HSV = new HSV(0, 0, 0);
        $color = $this->transition->interpolate(HSV::class, $HSV, $HSV, 0, 1);

        $this->assertInstanceOf(HSV::class, $color);
    }

    public function testGetNonExistingTransition()
    {
        $this->expectException(\RuntimeException::class);
        $HEX = new HEX('00', '00', '00');
        $color = $this->transition->interpolate(HEX::class, $HEX, $HEX, 0, 1);

        $this->assertInstanceOf(HEX::class, $color);
    }
}
