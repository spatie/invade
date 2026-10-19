<?php

namespace Spatie\Invade\Types;

use function PHPStan\Testing\assertType;

use Spatie\Invade\Invader;

/** @template TValue */
class GenericExample
{
    /**
     * @param TValue $value
     * @param string $readonlyValue
     */
    public function __construct(
        protected mixed $value,
        public readonly string $readonlyValue = 'original',
    ) {
    }

    /** @return TValue */
    protected function value(): mixed
    {
        return $this->value;
    }

    protected static function staticValue(string $argument): string
    {
        return $argument;
    }

    protected function fluent(): static
    {
        return $this;
    }

    /** @return array<int, static> */
    protected function fluentList(): array
    {
        return [$this];
    }

    /**
     * @template TArgument
     * @param TArgument $argument
     * @return TArgument
     */
    protected function echoArgument(mixed $argument): mixed
    {
        return $argument;
    }

    /** @return $this */
    protected function identity(): self
    {
        return $this;
    }
}

/** @extends GenericExample<string> */
class ChildExample extends GenericExample
{
}

/** @extends Invader<ChildExample> */
class ChildInvader extends Invader
{
}

$generic = new GenericExample('value');
assertType('Spatie\Invade\Types\GenericExample<string>', invade($generic)->fluent());

$example = new ChildExample('value');
assertType('string', invade($example)->value);
assertType('string', invade($example)->value());
assertType('string', invade($example)->staticValue('value'));
/** @phpstan-ignore method.staticCall */
invade($example)::staticValue('value');
assertType(ChildExample::class, invade($example)->fluent());
assertType(ChildExample::class, invade($example)->identity());
assertType('array<int, Spatie\Invade\Types\ChildExample>', invade($example)->fluentList());
assertType(ChildExample::class, invade($example)->echoArgument(argument: $example));
assertType('string', (new ChildInvader($example))->value);
assertType('string', (new ChildInvader($example))->value());
assertType('string', invade($example)->readonlyValue);
invade($example)->readonlyValue = 'changed';
/** @phpstan-ignore assign.propertyType */
(new ChildInvader($example))->value = 123;
/** @phpstan-ignore property.protected */
$inaccessibleProperty = $example->value;
/** @phpstan-ignore method.protected */
$inaccessibleMethod = $example->value();
