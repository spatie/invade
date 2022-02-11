<?php

use Spatie\Invade\Invador;

if (!function_exists('invade')) {
    function invade(object $object)
    {
        return new Invador($object);
    }
}
