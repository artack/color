<?php

namespace Artack\Color;

use Artack\Color\Color\HEX;
use Artack\Color\Color\HSV;
use Artack\Color\Color\RGB;
use Artack\Color\Transition\RGBTransition;
use PHPUnit\Framework\TestCase;

class TransitionTest extends TestCase
{

    public function testTransition()
    {
        $transition = new Transition(Factory::getTransitions(), new Converter(Factory::getConverters()));

        $this->assertInstanceOf(Transition::class, $transition);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongParameterRGBToHEX()
    {
        $HSV = new HSV(0, 0, 0);
        $RGBTransition = new RGBTransition();

        $RGBTransition->interpolate($HSV, $HSV, 0, 1);
    }

    public function testGetRGBTransition()
    {
        $transition = new Transition(Factory::getTransitions(), new Converter(Factory::getConverters()));

        $RGB = new RGB(0, 0, 0);
        $color = $transition->interpolate(RGB::class, $RGB, $RGB, 0, 1);

        $this->assertInstanceOf(RGB::class, $color);
    }

    public function testGetRGBTransitionWithHSVColors()
    {
        $transition = new Transition(Factory::getTransitions(), new Converter(Factory::getConverters()));

        $HSV = new HSV(0, 0, 0);
        $color = $transition->interpolate(RGB::class, $HSV, $HSV, 0, 1);

        $this->assertInstanceOf(RGB::class, $color);
    }

    public function testGetHSVTransitionWithRGBColors()
    {
        $transition = new Transition(Factory::getTransitions(), new Converter(Factory::getConverters()));

        $RGB = new RGB(0, 0, 0);
        $color = $transition->interpolate(HSV::class, $RGB, $RGB, 0, 1);

        $this->assertInstanceOf(HSV::class, $color);
    }

    public function testGetHSVTransition()
    {
        $transition = new Transition(Factory::getTransitions(), new Converter(Factory::getConverters()));

        $HSV = new HSV(0, 0, 0);
        $color = $transition->interpolate(HSV::class, $HSV, $HSV, 0, 1);

        $this->assertInstanceOf(HSV::class, $color);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetNonExistingTransition()
    {
        $transition = new Transition(Factory::getTransitions(), new Converter(Factory::getConverters()));

        $HEX = new HEX(0, 0, 0);
        $color = $transition->interpolate(HEX::class, $HEX, $HEX, 0, 1);

        $this->assertInstanceOf(HEX::class, $color);
    }

}
