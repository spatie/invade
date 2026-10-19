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

This package requires PHP 8.2 or later.

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

Further, you can also get and set private static class properties and call private static methods. Imagine having this class:

```php
class MyClass
{
    private static string $privateStaticProperty = 'privateValue';

    private static function privateStaticMethod(string $string, int $int): string
    {
        return 'private return value ' . $string . ' ' . $int;
    }
}
```

Here is how you get and set private class properties:

```php
invade(MyClass::class)->get('privateStaticProperty'); // returns 'private value'

invade(MyClass::class)->set('privateStaticProperty', 'changedValue');

invade(MyClass::class)->get('privateStaticProperty'); // returns 'changedValue'
```

And this is how you call private static methods:

```php
invade(MyClass::class)
    ->method('privateStaticMethod')
    ->call('foo', 123);

// returns 'private return value foo 123'
```

## PHPStan

The package ships a PHPStan extension, so calls through `invade` are analysed instead of reported. Without it PHPStan sees the private member on the invaded class and every access is an error:

```
Access to private property MyClass::$privateProperty.
```

With [phpstan/extension-installer](https://github.com/phpstan/extension-installer) the extension is picked up on install. Otherwise include it yourself:

```neon
includes:
    - vendor/spatie/invade/phpstan-extension.neon
```

Members are resolved against the invaded class and keep their own type and signature, so a read carries the real type, while a typo, a wrong argument, or a member the class does not have still fails.

The extension supports PHPStan 1.12 and 2.x. It analyses native instance members when the invaded object's type resolves to a single class, including inherited protected members and generic classes. Returns declared as `static` or `$this` are typed as the invaded class, not the wrapper. Readonly properties remain read-only in analysis.

Private members declared on a parent class remain inaccessible, matching the existing runtime behaviour. Narrow union types to a concrete class before invading them. The string-based `StaticInvader` API does not infer member types through this extension.

## Testing

```bash
composer test
composer analyse
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
