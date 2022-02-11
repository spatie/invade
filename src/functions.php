<?php

use Spatie\Invade\Invader;

if (! function_exists('invade')) {
    function invade(object $object)
    {
        return new Invader($object);
    }
}
