<?php

namespace Artack\Color;

use Artack\Color\Color\HEX;
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

    protected function setUp()
    {
        $this->converter = new Converter(new ConverterGraph(Factory::getConverterGraph()));
    }

    public function testConverter()
    {
        $this->assertInstanceOf(Converter::class, $this->converter);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testMultipleVertexId()
    {
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

    /**
     * @expectedException \RuntimeException
     */
    public function testNoneVertexId()
    {
        $graph = new Graph();

        $HEXVertex = $graph->createVertex(HEX::class);
        $RGBVertex = $graph->createVertex(RGB::class);

        $HEXVertex->createEdgeTo($RGBVertex)->setAttribute(Factory::GRAPH_EDGE_KEY_CONVERTER, new HEXToRGBConverter());

        $converter = new Converter(new ConverterGraph($graph));
        $RGB = new RGB(0, 0, 0);

        $converter->convert($RGB, HSV::class);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongParameterHSVToRGB()
    {
        $RGB = new RGB(0, 0, 0);
        $HSVToRGBConverter = new HSVToRGBConverter();

        $HSVToRGBConverter->convert($RGB);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongParameterRGBToHSV()
    {
        $HSV = new HSV(0, 0, 0);
        $RGBToHSVConverter = new RGBToHSVConverter();

        $RGBToHSVConverter->convert($HSV);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongParameterRGBToHEX()
    {
        $HSV = new HSV(0, 0, 0);
        $RGBToHEXConverter = new RGBToHEXConverter();

        $RGBToHEXConverter->convert($HSV);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongParameterHEXToRGB()
    {
        $HSV = new HSV(0, 0, 0);
        $HEXToRGBConverter = new HEXToRGBConverter();

        $HEXToRGBConverter->convert($HSV);
    }

    /**
     * @dataProvider colorProvider
     */
    public function testHEXtoHEX($red, $green, $blue, $hue, $saturation, $value, $hex)
    {
        /** @var HEX $color */
        $HEX = new HEX(substr($hex, 0, 2), substr($hex, 2, 2), substr($hex, 4, 2));
        $color = $this->converter->convert($HEX, HEX::class);

        $this->assertNotSame($color, $HEX);
        $this->assertEquals(strtolower($hex), (string)$color);
    }

    /**
     * @dataProvider colorProvider
     */
    public function testRGBtoRGB($red, $green, $blue, $hue, $saturation, $value, $hex)
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
    public function testHSTtoHST($red, $green, $blue, $hue, $saturation, $value, $hex)
    {
        /** @var HSV $color */
        $HSV = new HSV($hue, $saturation, $value);
        $color = $this->converter->convert($HSV, HSV::class);

        $this->assertNotSame($color, $HSV);
        $this->assertEquals($hue, $color->getHue());
        $this->assertEquals($saturation, round($color->getSaturation(), 2));
        $this->assertEquals($value, round($color->getValue(), 2));
    }

    /**
     * @dataProvider colorProvider
     */
    public function testRGBtoHSV($red, $green, $blue, $hue, $saturation, $value, $hex)
    {
        /** @var HSV $color */
        $color = $this->converter->convert(new RGB($red, $green, $blue), HSV::class);

        $this->assertEquals($hue, $color->getHue());
        $this->assertEquals($saturation, round($color->getSaturation(), 2));
        $this->assertEquals($value, round($color->getValue(), 2));
    }

    /**
     * @dataProvider colorProvider
     */
    public function testHSVtoRGB($red, $green, $blue, $hue, $saturation, $value, $hex)
    {
        /** @var RGB $color */
        $color = $this->converter->convert(new HSV($hue, $saturation, $value), RGB::class);

        $this->assertEquals($red, $color->getRed());
        $this->assertEquals($green, $color->getGreen());
        $this->assertEquals($blue, $color->getBlue());
    }

    /**
     * @dataProvider colorProvider
     */
    public function testRGBtoHEX($red, $green, $blue, $hue, $saturation, $value, $hex)
    {
        /** @var HEX $color */
        $color = $this->converter->convert(new RGB($red, $green, $blue), HEX::class);

        $this->assertEquals(strtolower($hex), (string)$color);
    }

    /**
     * @dataProvider colorProvider
     */
    public function testHEXtoRGB($red, $green, $blue, $hue, $saturation, $value, $hex)
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
    public function testHSVtoHEX($red, $green, $blue, $hue, $saturation, $value, $hex)
    {
        /** @var HEX $color */
        $color = $this->converter->convert(new HSV($hue, $saturation, $value), HEX::class);

        $this->assertEquals(strtolower($hex), (string)$color);
    }

    /**
     * @dataProvider colorProvider
     */
    public function testHEXtoHSV($red, $green, $blue, $hue, $saturation, $value, $hex)
    {
        /** @var HSV $color */
        $color = $this->converter->convert(new HEX(substr($hex, 0, 2), substr($hex, 2, 2), substr($hex, 4, 2)), HSV::class);

        $this->assertEquals($hue, $color->getHue());
        $this->assertEquals($saturation, round($color->getSaturation(), 2));
        $this->assertEquals($value, round($color->getValue(), 2));
    }

    public function colorProvider()
    {
        return [
            [  0,   0,   0,   0,   0,      0,    '000000'],
            [  0,   0,  85, 240, 100,     33.33, '000055'],
            [  0,   0, 170, 240, 100,     66.67, '0000AA'],
            [  0,   0, 255, 240, 100,    100,    '0000FF'],
            [  0,  85,   0, 120, 100,     33.33, '005500'],
            [  0,  85,  85, 180, 100,     33.33, '005555'],
            [  0,  85, 170, 210, 100,     66.67, '0055AA'],
            [  0,  85, 255, 220, 100,    100,    '0055FF'],
            [  0, 170,   0, 120, 100,     66.67, '00AA00'],
            [  0, 170,  85, 150, 100,     66.67, '00AA55'],
            [  0, 170, 170, 180, 100,     66.67, '00AAAA'],
            [  0, 170, 255, 200, 100,    100,    '00AAFF'],
            [  0, 255,   0, 120, 100,    100,    '00FF00'],
            [  0, 255,  85, 140, 100,    100,    '00FF55'],
            [  0, 255, 170, 160, 100,    100,    '00FFAA'],
            [  0, 255, 255, 180, 100,    100,    '00FFFF'],
            [ 85,   0,   0,   0, 100,     33.33, '550000'],
            [ 85,   0,  85, 300, 100,     33.33, '550055'],
            [ 85,   0, 170, 270, 100,     66.67, '5500AA'],
            [ 85,   0, 255, 260, 100,    100,    '5500FF'],
            [ 85,  85,   0,  60, 100,     33.33, '555500'],
            [ 85,  85,  85,   0,   0,     33.33, '555555'],
            [ 85,  85, 170, 240,  50,     66.67, '5555AA'],
            [ 85,  85, 255, 240,  66.67, 100,    '5555FF'],
            [ 85, 170,   0,  90, 100,     66.67, '55AA00'],
            [ 85, 170,  85, 120,  50,     66.67, '55AA55'],
            [ 85, 170, 170, 180,  50,     66.67, '55AAAA'],
            [ 85, 170, 255, 210,  66.67, 100,    '55AAFF'],
            [ 85, 255,   0, 100, 100,    100,    '55FF00'],
            [ 85, 255,  85, 120,  66.67, 100,    '55FF55'],
            [ 85, 255, 170, 150,  66.67, 100,    '55FFAA'],
            [ 85, 255, 255, 180,  66.67, 100,    '55FFFF'],
            [170,   0,   0,   0, 100,     66.67, 'AA0000'],
            [170,   0,  85, 330, 100,     66.67, 'AA0055'],
            [170,   0, 170, 300, 100,     66.67, 'AA00AA'],
            [170,   0, 255, 280, 100,    100,    'AA00FF'],
            [170,  85,   0,  30, 100,     66.67, 'AA5500'],
            [170,  85,  85,   0,  50,     66.67, 'AA5555'],
            [170,  85, 170, 300,  50,     66.67, 'AA55AA'],
            [170,  85, 255, 270,  66.67, 100,    'AA55FF'],
            [170, 170,   0,  60, 100,     66.67, 'AAAA00'],
            [170, 170,  85,  60,  50,     66.67, 'AAAA55'],
            [170, 170, 170,   0,   0,     66.67, 'AAAAAA'],
            [170, 170, 255, 240,  33.33, 100,    'AAAAFF'],
            [170, 255,   0,  80, 100,    100,    'AAFF00'],
            [170, 255,  85,  90,  66.67, 100,    'AAFF55'],
            [170, 255, 170, 120,  33.33, 100,    'AAFFAA'],
            [170, 255, 255, 180,  33.33, 100,    'AAFFFF'],
            [255,   0,   0,   0, 100,    100,    'FF0000'],
            [255,   0,  85, 340, 100,    100,    'FF0055'],
            [255,   0, 170, 320, 100,    100,    'FF00AA'],
            [255,   0, 255, 300, 100,    100,    'FF00FF'],
            [255,  85,   0,  20, 100,    100,    'FF5500'],
            [255,  85,  85,   0,  66.67, 100,    'FF5555'],
            [255,  85, 170, 330,  66.67, 100,    'FF55AA'],
            [255,  85, 255, 300,  66.67, 100,    'FF55FF'],
            [255, 170,   0,  40, 100,    100,    'FFAA00'],
            [255, 170,  85,  30,  66.67, 100,    'FFAA55'],
            [255, 170, 170,   0,  33.33, 100,    'FFAAAA'],
            [255, 170, 255, 300,  33.33, 100,    'FFAAFF'],
            [255, 255,   0,  60, 100,    100,    'FFFF00'],
            [255, 255,  85,  60,  66.67, 100,    'FFFF55'],
            [255, 255, 170,  60,  33.33, 100,    'FFFFAA'],
            [255, 255, 255,   0,   0,    100,    'FFFFFF'],
        ];
    }

}