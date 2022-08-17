<?php

declare(strict_types=1);
/**
 * This file is part of huangdijia/invade.
 *
 * @link     https://github.com/huangdijia/invade
 * @contact  huangdijia@gmail.com
 */
beforeEach(function () {
    $this->bar = new Bar();
});

it('can read a private property of an object', function () {
    $privateValue = invade($this->bar)->privateProperty;

    expect($privateValue)->toBe('privateValue');
})->expectExceptionMessage('Undefined property: Bar::$privateProperty');

it('can set the private property of an object', function () {
    invade($this->bar)->privateProperty = 'changedValue';

    $privateValue = invade($this->bar)->privateProperty;

    expect($privateValue)->toBe('changedValue');
});

it('can call the private method of an object', function () {
    $returnValue = invade($this->bar)->privateMethod();

    expect($returnValue)->toBe('private return value');
})->expectErrorMessage('Call to private method Foo::privateMethod() from scope Bar');

class Foo
{
    private string $privateProperty = 'privateValue';

    private function privateMethod(): string
    {
        return 'private return value';
    }
}

class Bar extends Foo
{
}
