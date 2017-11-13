# php-mapbox
A PHP Wrapper for the MapboxJS cURL API

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]

This package aims to take the API provided by Mapbox and create a simple PHP wrapper that allows you to call various different endpoints and return the results in various formats.

*At the moment this API will only return Geocoding results. Additional elements will be built on an as needed basis.*

## Install

Via Composer

``` bash
$ composer require zakclayton/php-mapbox
```

## Usage

``` php
$query        = 'The Statue of Liberty';
$mapbox       = new MapboxApi(MAPBOX_ACCESS_TOKEN);
$geoCodingApi = $mapbox->createGeoCodingApi($query);
$json         = $geoCodingApi->getJson();
$entity       = $geoCodingApi->call();
```

## Parameters

Coming soon.

## Testing

Tests are currently being written. Use this package with caution!

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email zak@24kdesign.co.uk instead of using the issue tracker.

## Credits

- [Zak Clayton][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/zakclayton/php-mapbox.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/zakclayton/php-mapbox/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/zakclayton/php-mapbox.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/zakclayton/php-mapbox.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/zakclayton/php-mapbox.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/zakclayton/php-mapbox
[link-travis]: https://travis-ci.org/zakclayton/php-mapbox
[link-scrutinizer]: https://scrutinizer-ci.com/g/zakclayton/php-mapbox/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/zakclayton/php-mapbox
[link-downloads]: https://packagist.org/packages/zakclayton/php-mapbox
[link-author]: https://github.com/ZakClayton
[link-contributors]: ../../contributors
