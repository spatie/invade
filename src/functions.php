<?php

use Spatie\Invade\Invader;
use Spatie\Invade\StaticInvader;

if (! function_exists('invade')) {
    /**
     * @template T of object
     *
     * @param T $object
     * @return Invader<T>
     */
    function invade(object $object): Invader
    {
        return new Invader($object);
    }
}

if (! function_exists('invadeStatic')) {
    /**
     * @param class-string $class
     * @return StaticInvader
     */
    function invadeStatic(string $class): StaticInvader
    {
        return new StaticInvader($class);
    }
}
