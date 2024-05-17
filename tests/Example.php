<?php

namespace Spatie\Invade\Tests;

class Example
{
    private static string $privateStaticProperty = 'privateValue';

    private static function privateStaticMethod(string $string, int $int): string
    {
        return 'private return value ' . $string . ' ' . $int;
    }
}
