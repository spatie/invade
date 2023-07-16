<?php

namespace Spatie\Invade;

use ReflectionClass;

/**
 * @template T of object
 * @mixin T
 */
class Invader
{
    /** @var T */
    public object $obj;
    public ReflectionClass $reflected;

    /**
     * @param T $obj
     */
    public function __construct(object $obj)
    {
        $this->obj = $obj;
        $this->reflected = new ReflectionClass($obj);
    }

    public function __get(string $name): mixed
    {
        return (fn () => $this->{$name})->call($this->obj);
    }

    public function __set(string $name, mixed $value): void
    {
        $property = $this->reflected->getProperty($name);

        $property->setAccessible(true);

        $property->setValue($this->obj, $value);
    }

    public function __call(string $name, array $params = []): mixed
    {
        return (fn () => $this->{$name}(...$params))->call($this->obj);
    }
}
