<?php

beforeEach(function () {
    $this->class = new class extends \Spatie\Invade\Tests\Base {

    };
});

it('can call the private method of an object', function () {
    $returnValue = invade($this->class)->basePrivateMethod();

    expect($returnValue)->toBe('base private method');
});
