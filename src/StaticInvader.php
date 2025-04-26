<?php

namespace Spatie\Invade;

use BadMethodCallException;

class StaticInvader
{
    private ?string $method = null;

    /**
     * @param class-string $className
     */
    public function __construct(
        public string $className,
    ) {
    }

    public function get(string $name): mixed
    {
        return (fn () => static::${$name})->bindTo(null, $this->className)();
    }

    public function set(string $name, mixed $value): void
    {
        (fn ($value) => static::${$name} = $value)->bindTo(null, $this->className)($value);
    }

    public function method(string $name): self
    {
        $this->method = $name;

        return $this;
    }

    /**
     * @throws BadMethodCallException
     */
    public function call(...$params): mixed
    {
        $this->method ?? throw new BadMethodCallException(
            'No method to be called. Use it like: invadeStatic(Foo::class)->method(\'bar\')->call()'
        );

        return (fn (string $method): mixed => static::$method(...$params))->bindTo(null, $this->className)($this->method);
    }
}
