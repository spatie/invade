<?php

namespace Spatie\Invade\Tests;

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
