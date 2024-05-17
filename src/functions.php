<?php

use Spatie\Invade\Invader;
use Spatie\Invade\StaticInvader;

if (! function_exists('invade')) {
    /**
     * @template T of object
     *
     * @param T|class-string $object
     * @return Invader<T>|StaticInvader
     */
    function invade(object|string $object): Invader|StaticInvader
    {
        if (is_object($object)) {
            return new Invader($object);
        }

        return new StaticInvader($object);
    }
}
