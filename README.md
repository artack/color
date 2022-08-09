artack/color
============

> color conversions and transitions (e.g. interpolation).


[![Latest Release](https://img.shields.io/packagist/v/artack/color.svg)](https://packagist.org/packages/artack/color)
[![MIT License](https://img.shields.io/packagist/l/artack/color.svg)](http://opensource.org/licenses/MIT)
[![Total Downloads](https://img.shields.io/packagist/dt/artack/color.svg)](https://packagist.org/packages/artack/color)

Developed by [ARTACK WebLab GmbH](https://www.artack.ch) in Zurich, Switzerland.


Features
--------

- Provides class representation for **RGB**, **CMYK**, **HSV**, **HSL** and **HEX**.
- Provides conversion between all class representation
- Provides transitions between colors (e.g. interpolation)
- Provides clear exceptions to be able to handle library exceptions
- Compatible with PHP >= 7 and >= 8.


Installation
------------

You can install this color library through [Composer](https://getcomposer.org):

```shell
$ composer require artack/color
```

Usage
-----
Creating a RGB class representation:

```php
$RGB = new RGB(0, 255, 0);
echo $RGB->getGreen(); // 255
```

Translate RGR class representation to HSV:
```php
$converter = Factory::createConverter();
$RGB = new RGB(0, 255, 0);

$HSV = $converter->convert($RGB, HSV::class);
```

Get an interpolation color between two colors with the value (and max) given:
```php
$transition = Factory::createTransition();
        
$RGBRed = new RGB(255, 0, 0); // red
$RGBGreen = new RGB(0, 255, 0); // green

$RGBInterpolated = $transition->interpolate(RGB::class, $RGBRed, $RGBGreen, 100, 200); // should be ~yellow

// Interpolation will give better results when using HSV Transition. Colors get converted automatically if needed.
$HSVInterpolated = $transition->interpolate(HSV::class, $RGBRed, $RGBGreen, 100, 200); // should be ~yellow
```