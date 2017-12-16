<?php

declare(strict_types=1);

namespace Artack\Color\Transition;

use Artack\Color\Color\HSV;
use PHPUnit\Framework\TestCase;

class HSVTransitionTest extends TestCase
{
    /**
     * @dataProvider interpolationProvider
     */
    public function testInterpolation($startHue, $startSaturation, $startValue, $endHue, $endSaturation, $endValue, $value, $max, $expectedHue, $expectedSaturation, $expectedValue)
    {
        $start = new HSV($startHue, $startSaturation, $startValue);
        $end = new HSV($endHue, $endSaturation, $endValue);

        /** @var HSV $color */
        $transition = new HSVTransition();
        $color = $transition->interpolate($start, $end, $value, $max);

        $this->assertEquals($expectedHue, $color->getHue());
        $this->assertEquals($expectedSaturation, $color->getSaturation());
        $this->assertEquals($expectedValue, $color->getValue());
    }

    public function interpolationProvider()
    {
        return [
            [0,   0,   0, 360, 100, 100,   0, 200,   0,   0,   0],
            [0,   0,   0, 360, 100, 100, 100, 200, 180,  50,  50],
            [0,   0,   0, 360, 100, 100, 200, 200, 360, 100, 100],
            [100,  20,  20, 200,  80,  80,   0, 200, 100,  20,  20],
            [100,  20,  20, 200,  80,  80, 100, 200, 150,  50,  50],
            [100,  20,  20, 200,  80,  80, 200, 200, 200,  80,  80],
        ];
    }
}
