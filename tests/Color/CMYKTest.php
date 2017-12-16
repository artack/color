<?php

declare(strict_types=1);

namespace Artack\Color\Color;

use PHPUnit\Framework\TestCase;

class CMYKTest extends TestCase
{
    /**
     * @dataProvider correctInputProvider
     */
    public function testCMYKCanBeCreated($cyan, $magenta, $yellow, $key)
    {
        $RGB = new CMYK($cyan, $magenta, $yellow, $key);

        $this->assertInstanceOf(CMYK::class, $RGB);
        $this->assertInstanceOf(Color::class, $RGB);

        $this->assertEquals($cyan, $RGB->getCyan());
        $this->assertEquals($magenta, $RGB->getMagenta());
        $this->assertEquals($yellow, $RGB->getYellow());
        $this->assertEquals($key, $RGB->getKey());
    }

    /**
     * @dataProvider wrongInputProvider
     * @expectedException \InvalidArgumentException
     */
    public function testCMYKCanNotBeCreated($cyan, $magenta, $yellow, $key)
    {
        new CMYK($cyan, $magenta, $yellow, $key);
    }

    public function correctInputProvider()
    {
        return [
            [0.0,   0.0,   0.0,   0.0],
            [50.0,  50.0,  50.0,  50.0],
            [100.0, 100.0, 100.0, 100.0],
        ];
    }

    public function wrongInputProvider()
    {
        return [
            [-0.01, 50.0, 50.0, 50.0],
            [100.01, 50.0, 50.0, 50.0],

            [50.0,  -0.01, 50.0, 50.0],
            [50.0, 100.01, 50.0, 50.0],

            [50.0, 50.0,  -0.01, 50.0],
            [50.0, 50.0, 100.01, 50.0],

            [50.0, 50.0, 50.0,  -0.01],
            [50.0, 50.0, 50.0, 100.01],
        ];
    }
}
