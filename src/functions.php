<?php

use Spatie\Invade\Invader;

function invade(object $object)
{
    return new Invader($object);
}
