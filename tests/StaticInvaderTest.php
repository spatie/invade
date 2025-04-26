<?php

namespace Spatie\Invade\Tests;

use BadMethodCallException;

beforeEach(function () {
    if (invade(Example::class)->get('privateStaticProperty') === 'changedValue') {
        invade(Example::class)->set('privateStaticProperty', 'privateValue');
    }
});

it('reads a static private property', function () {
    $privateValue = invade(Example::class)->get('privateStaticProperty');

    expect($privateValue)->toBe('privateValue');
});

it('sets a private static property', function () {
    invade(Example::class)->set('privateStaticProperty', 'changedValue');

    $privateValue = invade(Example::class)->get('privateStaticProperty');

    expect($privateValue)->toBe('changedValue');
});

it('calls a private static method', function () {
    $returnValue = invade(Example::class)
        ->method('privateStaticMethod')
        ->call('test', 123);

    expect($returnValue)->toBe('private return value test 123');
});

it('throws an exception when trying to call a method without setting it first', function () {
    expect(function () {
        invade(Example::class)->call();
    })->toThrow(BadMethodCallException::class, 'No method to be called. Use it like: invadeStatic(Foo::class)->method(\'bar\')->call()');
});