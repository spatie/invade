<?php

namespace Spatie\Invade\Tests;

use InvalidArgumentException;

beforeEach(function () {
    $this->class = new class () extends SuperclassExample {};
});

it('can call the private method of the superclass through the subclass', function () {
    $returnValue = invade($this->class)->superclassPrivateMethod();

    expect($returnValue)->toBe('superclass private method');
});

it('expects exception when method could NOT be found', function () {
    expect(function () {
        invade($this->class)->invalidMethod();
    })->toThrow(InvalidArgumentException::class, 'Method invalidMethod not found in class hierarchy');
});

it('can read a private property of the superclass through the subclass', function () {
    $privateValue = invade($this->class)->superclassPrivateProperty;

    expect($privateValue)->toBe('superclassPrivateValue');
});

it('expects exception when property could NOT be found', function () {
    expect(function () {
        invade($this->class)->invalidParameter;
    })->toThrow(InvalidArgumentException::class, 'Property invalidParameter not found in class hierarchy');
});

it('can set the superclass private property', function () {
    invade($this->class)->superclassPrivateProperty = 'changedValue';
    $privateValue = invade($this->class)->superclassPrivateProperty;

    expect($privateValue)->toBe('changedValue');
});
