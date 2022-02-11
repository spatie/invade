<?php

use Spatie\Invade\Invador;

function invade(object $object)
{
    return new Invador($object);
}
