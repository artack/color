artack/color
============

> color conversions and transitions (e.g. interpolation).


[![Build Status](https://img.shields.io/travis/ARTACK/color.svg?style=flat)](https://travis-ci.org/ARTACK/color)
[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/artack/color.svg?style=flat)](https://scrutinizer-ci.com/g/artack/color/)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/artack/color.svg)](https://scrutinizer-ci.com/g/artack/color/)
[![Latest Release](https://img.shields.io/packagist/v/artack/color.svg)](https://packagist.org/packages/artack/color)
[![MIT License](https://img.shields.io/packagist/l/artack/color.svg)](http://opensource.org/licenses/MIT)
[![Total Downloads](https://img.shields.io/packagist/dt/artack/color.svg)](https://packagist.org/packages/artack/color)

Developed by [ARTACK WebLab GmbH](https://www.artack.ch) in Zurich, Switzerland.


Features
--------

- Provides class representation for **RGB**, **HSV** and **HEX**.
- Provides conversion between (not yet) all class representation
- PSR-4 compatible.
- Compatible with PHP >= 7.


Installation
------------

You can install ARTACK's color library through [Composer](https://getcomposer.org):

```shell
$ composer require artack/color
```

Usage
-----
Creating a RGB class representation:

```php
use Artack\Color\Color\RGB;

$RGB = new RGB(0, 255, 0);
echo $RGB->getGreen(); // 255
```

Translate RGR class representation to HSV:
```php
use Artack\Color\Color\RGB;
use Artack\Color\Color\HSV;
use Artack\Color\Converter;
use Artack\Color\Factory;

$converter = Factory::createConverter();
$RGB = new RGB(0, 255, 0);

$converter->convert($RGB, HSV::class);
```

Get an interpolation color between two colors with the value (and max) given:
```php
use Artack\Color\Color\RGB;
use Artack\Color\Color\HSV;
use Artack\Color\Transition\RGBTransition;

$transition = Factory::createTransition();
        
$RGBRed = new RGB(255, 0, 0); // red
$RGBGreen = new RGB(0, 255, 0); // green

$RGBInterpolated = $transition->interpolate(RGB::class, $RGBRed, $RGBGreen, 100, 200); // should be ~yellow

// Interpolation will give better results when using HSV Transition. Colors get converted automaticly if needed.
$HSVInterpolated = $transition->interpolate(HSV::class, $RGBRed, $RGBGreen, 100, 200); // should be ~yellow
```