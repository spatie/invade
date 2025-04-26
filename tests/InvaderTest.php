<?php

namespace Spatie\Invade\Tests;

use Spatie\Invade\Invader;

beforeEach(function () {
    $this->class = new class () {
        private string $privateProperty = 'privateValue';

        private function privateMethod(): string
        {
            return 'private return value';
        }
    };
});

it('creates invader instance for object', function () {
    $invader = invade($this->class);

    expect($invader)
        ->toBeInstanceOf(Invader::class)
        ->obj->toBe($this->class);
});

it('can read a private property of an object', function () {
    $privateValue = invade($this->class)->privateProperty;

    expect($privateValue)->toBe('privateValue');
});

it('can set the private property of an object', function () {
    invade($this->class)->privateProperty = 'changedValue';

    $privateValue = invade($this->class)->privateProperty;

    expect($privateValue)->toBe('changedValue');
});

it('can call the private method of an object', function () {
    $returnValue = invade($this->class)->privateMethod();

    expect($returnValue)->toBe('private return value');
});
