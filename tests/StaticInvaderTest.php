<?php

namespace Spatie\Invade\Tests;

beforeEach(function () {
    if (invadeStatic(Example::class)->get('privateProperty') === 'changedValue') {
        invadeStatic(Example::class)->set('privateProperty', 'privateValue');
    }
});

it('reads a static private property', function () {
    $privateValue = invadeStatic(Example::class)->get('privateProperty');

    expect($privateValue)->toBe('privateValue');
});

it('sets a private static property', function () {
    invadeStatic(Example::class)->set('privateProperty', 'changedValue');

    $privateValue = invadeStatic(Example::class)->get('privateProperty');

    expect($privateValue)->toBe('changedValue');
});

it('calls a private static method', function () {
    $returnValue = invadeStatic(Example::class)
        ->method('privateMethod')
        ->call('test', 123);

    expect($returnValue)->toBe('private return value test 123');
});
