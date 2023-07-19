<p align="center"><img src="/art/socialcard.png" alt="Social Card of Invade"></p>

# A PHP function to access private properties and methods

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/invade.svg?style=flat-square)](https://packagist.org/packages/spatie/invade)
[![Tests](https://github.com/spatie/invade/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/spatie/invade/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/invade.svg?style=flat-square)](https://packagist.org/packages/spatie/invade)

This package offers an `invade` function that will allow you to read/write private properties of an object. It will also allow you to call private methods.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/invade.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/invade)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/invade
```

## Usage

Imagine you have this class defined which has a private property and method.

```php
class MyClass
{
    private string $privateProperty = 'private value';

    private function privateMethod(): string
    {
        return 'private return value';
    }
}

$myClass = new Myclass();
```

This is how you can get the value of the private property using the `invade` function.

```php
invade($myClass)->privateProperty; // returns 'private value'
```

The `invade` function also allows you to change private values.

```php
invade($myClass)->privateProperty = 'changed value';
invade($myClass)->privateProperty; // returns 'changed value
```

Using `invade` you can also call private functions.

```php
invade($myClass)->privateMethod(); // returns 'private return value'
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/spatie)
- [All Contributors](../../contributors)

And a special thanks to [Caneco](https://twitter.com/caneco) for the logo ✨

The [original idea](https://twitter.com/calebporzio/status/1492141967404371968) for the `invade` function came from [Caleb "string king" Porzio](https://twitter.com/calebporzio). We slightly polished the code that he created in [this commit on Livewire](https://github.com/livewire/livewire/pull/4649/files).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
