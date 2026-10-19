<?php

beforeEach(function () {
    $this->class = new class () {
        private string $privateProperty = 'privateValue';

        private function privateMethod(): string
        {
            return 'private return value';
        }
    };
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

it('returns the invaded object from a fluent method', function () {
    $object = new class () {
        protected function fluent(): static
        {
            return $this;
        }
    };

    expect(invade($object)->fluent())->toBe($object);
});

it('cannot overwrite an initialized readonly property', function () {
    $object = new class ('original') {
        public function __construct(private readonly string $value)
        {
        }
    };

    expect(invade($object)->value)->toBe('original');
    expect(function () use ($object) {
        invade($object)->value = 'changed';
    })->toThrow(Error::class, 'Cannot modify readonly property');
    expect(invade($object)->value)->toBe('original');
});
