<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Color\CMYK;
use Artack\Color\Color\HEX;
use Artack\Color\Color\HSL;
use Artack\Color\Color\HSV;
use Artack\Color\Color\RGB;
use Artack\Color\Converter\HEXToRGBConverter;
use Artack\Color\Converter\HSVToRGBConverter;
use Artack\Color\Converter\RGBToHEXConverter;
use Artack\Color\Converter\RGBToHSVConverter;
use Fhaculty\Graph\Graph;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    /** @var Converter */
    private $converter;

    protected function setUp(): void
    {
        $this->converter = Factory::createConverter();
    }

    public function testConverter()
    {
        $this->assertInstanceOf(Converter::class, $this->converter);
    }

    public function testMultipleVertexId()
    {
        $this->expectException(\RuntimeException::class);
        $graph = new Graph();

        $RGBVertex = $graph->createVertex(RGB::class);
        $HST1Vertex = $graph->createVertex(HSV::class);
        $HST2Vertex = $graph->createVertex(HSV::class);

        $RGBVertex->createEdgeTo($HST1Vertex)->setAttribute(Factory::GRAPH_EDGE_KEY_CONVERTER, new RGBToHSVConverter());
        $RGBVertex->createEdgeTo($HST2Vertex)->setAttribute(Factory::GRAPH_EDGE_KEY_CONVERTER, new RGBToHSVConverter());

        $converter = new Converter(new ConverterGraph($graph));
        $RGB = new RGB(0, 0, 0);

        $converter->convert($RGB, HSV::class);
    }

    public function testNoneVertexId()
    {
        $this->expectException(\RuntimeException::class);
        $graph = new Graph();

        $HEXVertex = $graph->createVertex(HEX::class);
        $RGBVertex = $graph->createVertex(RGB::class);

        $HEXVertex->createEdgeTo($RGBVertex)->setAttribute(Factory::GRAPH_EDGE_KEY_CONVERTER, new HEXToRGBConverter());

        $converter = new Converter(new ConverterGraph($graph));
        $RGB = new RGB(0, 0, 0);

        $converter->convert($RGB, HSV::class);
    }

    public function testWrongParameterHSVToRGB()
    {
        $this->expectException(\InvalidArgumentException::class);
        $RGB = new RGB(0, 0, 0);
        $HSVToRGBConverter = new HSVToRGBConverter();

        $HSVToRGBConverter->convert($RGB);
    }

    public function testWrongParameterRGBToHSV()
    {
        $this->expectException(\InvalidArgumentException::class);
        $HSV = new HSV(0, 0, 0);
        $RGBToHSVConverter = new RGBToHSVConverter();

        $RGBToHSVConverter->convert($HSV);
    }

    public function testWrongParameterRGBToHEX()
    {
        $this->expectException(\InvalidArgumentException::class);
        $HSV = new HSV(0, 0, 0);
        $RGBToHEXConverter = new RGBToHEXConverter();

        $RGBToHEXConverter->convert($HSV);
    }

    public function testWrongParameterHEXToRGB()
    {
        $this->expectException(\InvalidArgumentException::class);
        $HSV = new HSV(0, 0, 0);
        $HEXToRGBConverter = new HEXToRGBConverter();

        $HEXToRGBConverter->convert($HSV);
    }

    /**
     * @dataProvider colorProvider
     */
    public function testHEXtoHEX($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var HEX $color */
        $HEX = new HEX(substr($hex, 0, 2), substr($hex, 2, 2), substr($hex, 4, 2));
        $color = $this->converter->convert($HEX, HEX::class);

        $this->assertNotSame($color, $HEX);
        $this->assertEquals(strtolower($hex), (string) $color);
    }

    /**
     * @dataProvider colorProvider
     */
    public function testRGBtoRGB($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var RGB $color */
        $RGB = new RGB($red, $green, $blue);
        $color = $this->converter->convert($RGB, RGB::class);

        $this->assertNotSame($color, $RGB);
        $this->assertEquals($red, $color->getRed());
        $this->assertEquals($green, $color->getGreen());
        $this->assertEquals($blue, $color->getBlue());
    }

    /**
     * @dataProvider colorProvider
     */
    public function testHSVtoHSV($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var HSV $color */
        $HSV = new HSV($HSVHue, $HSVSaturation, $HSVValue);
        $color = $this->converter->convert($HSV, HSV::class);

        $this->assertNotSame($color, $HSV);
        $this->assertEquals($HSVHue, $color->getHue());
        $this->assertEquals($HSVSaturation, round($color->getSaturation(), 2));
        $this->assertEquals($HSVValue, round($color->getValue(), 2));
    }

    /**
     * @dataProvider colorProvider
     */
    public function testCMYKtoCMYK($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var CMYK $color */
        $CMYK = new CMYK($cyan, $magenta, $yellow, $key);
        $color = $this->converter->convert($CMYK, CMYK::class);

        $this->assertNotSame($color, $CMYK);
        $this->assertEquals($cyan, $color->getCyan());
        $this->assertEquals($magenta, $color->getMagenta());
        $this->assertEquals($yellow, $color->getYellow());
        $this->assertEquals($key, $color->getKey());
    }

    /**
     * @dataProvider colorProvider
     */
    public function testRGBtoHSV($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var HSV $color */
        $color = $this->converter->convert(new RGB($red, $green, $blue), HSV::class);

        $this->assertEquals($HSVHue, $color->getHue());
        $this->assertEquals($HSVSaturation, round($color->getSaturation(), 2));
        $this->assertEquals($HSVValue, round($color->getValue(), 2));
    }

    /**
     * @dataProvider colorProvider
     */
    public function testHSVtoRGB($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var RGB $color */
        $color = $this->converter->convert(new HSV($HSVHue, $HSVSaturation, $HSVValue), RGB::class);

        $this->assertEquals($red, $color->getRed());
        $this->assertEquals($green, $color->getGreen());
        $this->assertEquals($blue, $color->getBlue());
    }

    /**
     * @dataProvider colorProvider
     */
    public function testRGBtoHEX($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var HEX $color */
        $color = $this->converter->convert(new RGB($red, $green, $blue), HEX::class);

        $this->assertEquals(strtolower($hex), (string) $color);
    }

    /**
     * @dataProvider colorProvider
     */
    public function testHEXtoRGB($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var RGB $color */
        $color = $this->converter->convert(new HEX(substr($hex, 0, 2), substr($hex, 2, 2), substr($hex, 4, 2)), RGB::class);

        $this->assertEquals($red, $color->getRed());
        $this->assertEquals($green, $color->getGreen());
        $this->assertEquals($blue, $color->getBlue());
    }

    /**
     * @dataProvider colorProvider
     */
    public function testHSVtoHEX($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var HEX $color */
        $color = $this->converter->convert(new HSV($HSVHue, $HSVSaturation, $HSVValue), HEX::class);

        $this->assertEquals(strtolower($hex), (string) $color);
    }

    /**
     * @dataProvider colorProvider
     */
    public function testHEXtoHSV($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var HSV $color */
        $color = $this->converter->convert(new HEX(substr($hex, 0, 2), substr($hex, 2, 2), substr($hex, 4, 2)), HSV::class);

        $this->assertEquals($HSVHue, $color->getHue());
        $this->assertEquals($HSVSaturation, round($color->getSaturation(), 2));
        $this->assertEquals($HSVValue, round($color->getValue(), 2));
    }

    /**
     * @dataProvider colorProvider
     */
    public function testRGBtoCMYK($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var CMYK $color */
        $color = $this->converter->convert(new RGB($red, $green, $blue), CMYK::class);

        $this->assertEquals($cyan, round($color->getCyan(), 2));
        $this->assertEquals($magenta, round($color->getMagenta(), 2));
        $this->assertEquals($yellow, round($color->getYellow(), 2));
        $this->assertEquals($key, round($color->getKey(), 2));
    }

    /**
     * @dataProvider colorProvider
     */
    public function testCMYKtoRGB($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var RGB $color */
        $color = $this->converter->convert(new CMYK($cyan, $magenta, $yellow, $key), RGB::class);

        $this->assertEquals($red, $color->getRed());
        $this->assertEquals($green, $color->getGreen());
        $this->assertEquals($blue, $color->getBlue());
    }

    /**
     * @dataProvider colorProvider
     */
    public function testRGBtoHSL($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var HSL $color */
        $color = $this->converter->convert(new RGB($red, $green, $blue), HSL::class);

        $this->assertEquals($HSLHue, $color->getHue());
        $this->assertEquals($HSLSaturation, round($color->getSaturation(), 2));
        $this->assertEquals($HSLLightning, round($color->getLightness(), 2));
    }

    /**
     * @dataProvider colorProvider
     */
    public function testHSLtoRGB($red, $green, $blue, $HSVHue, $HSVSaturation, $HSVValue, $HSLHue, $HSLSaturation, $HSLLightning, $hex, $cyan, $magenta, $yellow, $key)
    {
        /** @var RGB $color */
        $color = $this->converter->convert(new HSL($HSLHue, $HSLSaturation, $HSLLightning), RGB::class);

        $this->assertEquals($red, $color->getRed());
        $this->assertEquals($green, $color->getGreen());
        $this->assertEquals($blue, $color->getBlue());
    }

    public function colorProvider(): array
    {
        return [
            [0,     0,   0,   0,   0,      0,      0,   0,      0,    '000000',   0,      0,      0,    100],
            [0,     0,  85, 240, 100,     33.33, 240, 100,     16.67, '000055', 100,    100,      0,     66.67],
            [0,     0, 170, 240, 100,     66.67, 240, 100,     33.33, '0000AA', 100,    100,      0,     33.33],
            [0,     0, 255, 240, 100,    100,    240, 100,     50,    '0000FF', 100,    100,      0,      0],
            [0,    85,   0, 120, 100,     33.33, 120, 100,     16.67, '005500', 100,      0,    100,     66.67],
            [0,    85,  85, 180, 100,     33.33, 180, 100,     16.67, '005555', 100,      0,      0,     66.67],
            [0,    85, 170, 210, 100,     66.67, 210, 100,     33.33, '0055AA', 100,     50,      0,     33.33],
            [0,    85, 255, 220, 100,    100,    220, 100,     50,    '0055FF', 100,     66.67,   0,      0],
            [0,   170,   0, 120, 100,     66.67, 120, 100,     33.33, '00AA00', 100,      0,    100,     33.33],
            [0,   170,  85, 150, 100,     66.67, 150, 100,     33.33, '00AA55', 100,      0,     50,     33.33],
            [0,   170, 170, 180, 100,     66.67, 180, 100,     33.33, '00AAAA', 100,      0,      0,     33.33],
            [0,   170, 255, 200, 100,    100,    200, 100,     50,    '00AAFF', 100,     33.33,   0,      0],
            [0,   255,   0, 120, 100,    100,    120, 100,     50,    '00FF00', 100,      0,    100,      0],
            [0,   255,  85, 140, 100,    100,    140, 100,     50,    '00FF55', 100,      0,     66.67,   0],
            [0,   255, 170, 160, 100,    100,    160, 100,     50,    '00FFAA', 100,      0,     33.33,   0],
            [0,   255, 255, 180, 100,    100,    180, 100,     50,    '00FFFF', 100,      0,      0,      0],
            [85,    0,   0,   0, 100,     33.33,   0, 100,     16.67, '550000',   0,    100,    100,     66.67],
            [85,    0,  85, 300, 100,     33.33, 300, 100,     16.67, '550055',   0,    100,      0,     66.67],
            [85,    0, 170, 270, 100,     66.67, 270, 100,     33.33, '5500AA',  50,    100,      0,     33.33],
            [85,    0, 255, 260, 100,    100,    260, 100,     50,    '5500FF',  66.67, 100,      0,      0],
            [85,   85,   0,  60, 100,     33.33,  60, 100,     16.67, '555500',   0,      0,    100,     66.67],
            [85,   85,  85,   0,   0,     33.33,   0,   0,     33.33, '555555',   0,      0,      0,     66.67],
            [85,   85, 170, 240,  50,     66.67, 240,  33.33,  50,    '5555AA',  50,     50,      0,     33.33],
            [85,   85, 255, 240,  66.67, 100,    240, 100,     66.67, '5555FF',  66.67,  66.67,   0,      0],
            [85,  170,   0,  90, 100,     66.67,  90, 100,     33.33, '55AA00',  50,      0,    100,     33.33],
            [85,  170,  85, 120,  50,     66.67, 120,  33.33,  50,    '55AA55',  50,      0,     50,     33.33],
            [85,  170, 170, 180,  50,     66.67, 180,  33.33,  50,    '55AAAA',  50,      0,      0,     33.33],
            [85,  170, 255, 210,  66.67, 100,    210, 100,     66.67, '55AAFF',  66.67,  33.33,   0,      0],
            [85,  255,   0, 100, 100,    100,    100, 100,     50,    '55FF00',  66.67,   0,    100,      0],
            [85,  255,  85, 120,  66.67, 100,    120, 100,     66.67, '55FF55',  66.67,   0,     66.67,   0],
            [85,  255, 170, 150,  66.67, 100,    150, 100,     66.67, '55FFAA',  66.67,   0,     33.33,   0],
            [85,  255, 255, 180,  66.67, 100,    180, 100,     66.67, '55FFFF',  66.67,   0,      0,      0],
            [170,   0,   0,   0, 100,     66.67,   0, 100,     33.33, 'AA0000',   0,    100,    100,     33.33],
            [170,   0,  85, 330, 100,     66.67, 330, 100,     33.33, 'AA0055',   0,    100,     50,     33.33],
            [170,   0, 170, 300, 100,     66.67, 300, 100,     33.33, 'AA00AA',   0,    100,      0,     33.33],
            [170,   0, 255, 280, 100,    100,    280, 100,     50,    'AA00FF',  33.33, 100,      0,      0],
            [170,  85,   0,  30, 100,     66.67,  30, 100,     33.33, 'AA5500',   0,     50,    100,     33.33],
            [170,  85,  85,   0,  50,     66.67,   0,  33.33,  50,    'AA5555',   0,     50,     50,     33.33],
            [170,  85, 170, 300,  50,     66.67, 300,  33.33,  50,    'AA55AA',   0,     50,      0,     33.33],
            [170,  85, 255, 270,  66.67, 100,    270, 100,     66.67, 'AA55FF',  33.33,  66.67,   0,      0],
            [170, 170,   0,  60, 100,     66.67,  60, 100,     33.33, 'AAAA00',   0,      0,    100,     33.33],
            [170, 170,  85,  60,  50,     66.67,  60,  33.33,  50,    'AAAA55',   0,      0,     50,     33.33],
            [170, 170, 170,   0,   0,     66.67,   0,   0,     66.67, 'AAAAAA',   0,      0,      0,     33.33],
            [170, 170, 255, 240,  33.33, 100,    240, 100,     83.33, 'AAAAFF',  33.33,  33.33,   0,      0],
            [170, 255,   0,  80, 100,    100,     80, 100,     50,    'AAFF00',  33.33,   0,    100,      0],
            [170, 255,  85,  90,  66.67, 100,     90, 100,     66.67, 'AAFF55',  33.33,   0,     66.67,   0],
            [170, 255, 170, 120,  33.33, 100,    120, 100,     83.33, 'AAFFAA',  33.33,   0,     33.33,   0],
            [170, 255, 255, 180,  33.33, 100,    180, 100,     83.33, 'AAFFFF',  33.33,   0,      0,      0],
            [255,   0,   0,   0, 100,    100,      0, 100,     50,    'FF0000',   0,    100,    100,      0],
            [255,   0,  85, 340, 100,    100,    340, 100,     50,    'FF0055',   0,    100,     66.67,   0],
            [255,   0, 170, 320, 100,    100,    320, 100,     50,    'FF00AA',   0,    100,     33.33,   0],
            [255,   0, 255, 300, 100,    100,    300, 100,     50,    'FF00FF',   0,    100,      0,      0],
            [255,  85,   0,  20, 100,    100,     20, 100,     50,    'FF5500',   0,     66.67, 100,      0],
            [255,  85,  85,   0,  66.67, 100,      0, 100,     66.67, 'FF5555',   0,     66.67,  66.67,   0],
            [255,  85, 170, 330,  66.67, 100,    330, 100,     66.67, 'FF55AA',   0,     66.67,  33.33,   0],
            [255,  85, 255, 300,  66.67, 100,    300, 100,     66.67, 'FF55FF',   0,     66.67,   0,      0],
            [255, 170,   0,  40, 100,    100,     40, 100,     50,    'FFAA00',   0,     33.33, 100,      0],
            [255, 170,  85,  30,  66.67, 100,     30, 100,     66.67, 'FFAA55',   0,     33.33,  66.67,   0],
            [255, 170, 170,   0,  33.33, 100,      0, 100,     83.33, 'FFAAAA',   0,     33.33,  33.33,   0],
            [255, 170, 255, 300,  33.33, 100,    300, 100,     83.33, 'FFAAFF',   0,     33.33,   0,      0],
            [255, 255,   0,  60, 100,    100,     60, 100,     50,    'FFFF00',   0,      0,    100,      0],
            [255, 255,  85,  60,  66.67, 100,     60, 100,     66.67, 'FFFF55',   0,      0,     66.67,   0],
            [255, 255, 170,  60,  33.33, 100,     60, 100,     83.33, 'FFFFAA',   0,      0,     33.33,   0],
            [255, 255, 255,   0,   0,    100,      0,   0,    100,    'FFFFFF',   0,      0,      0,      0],
            [128, 128, 128,   0,   0,     50.2,    0,   0,     50.2,    '808080',   0,      0,      0,   49.8],
        ];
    }
}
