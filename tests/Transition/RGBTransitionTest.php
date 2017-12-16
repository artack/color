<?php

declare(strict_types=1);

namespace Artack\Color\Transition;

use Artack\Color\Color\RGB;
use PHPUnit\Framework\TestCase;

class RGBTransitionTest extends TestCase
{
    /**
     * @dataProvider interpolationProvider
     */
    public function testInterpolation($startRed, $startGreen, $startBlue, $endRed, $endGreen, $endBlue, $value, $max, $expectedRed, $expectedGreen, $expectedBlue)
    {
        $start = new RGB($startRed, $startGreen, $startBlue);
        $end = new RGB($endRed, $endGreen, $endBlue);

        /** @var RGB $color */
        $transition = new RGBTransition();
        $color = $transition->interpolate($start, $end, $value, $max);

        $this->assertEquals($expectedRed, $color->getRed());
        $this->assertEquals($expectedGreen, $color->getGreen());
        $this->assertEquals($expectedBlue, $color->getBlue());
    }

    public function interpolationProvider()
    {
        return [
            [0,   0,   0, 255, 255, 255,   0, 200,   0,   0,   0],
            [0,   0,   0, 255, 255, 255, 100, 200, 128, 128, 128],
            [0,   0,   0, 255, 255, 255, 200, 200, 255, 255, 255],
            [100, 100, 100, 200, 200, 200,   0, 200, 100, 100, 100],
            [100, 100, 100, 200, 200, 200, 100, 200, 150, 150, 150],
            [100, 100, 100, 200, 200, 200, 200, 200, 200, 200, 200],
        ];
    }
}
