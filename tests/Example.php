<?php

namespace Spatie\Invade\Tests;

class Example
{
    private static string $privateProperty = 'privateValue';

    private static function privateMethod(string $string, int $int): string
    {
        return 'private return value ' . $string . ' ' . $int;
    }
}
