<?php

namespace Spatie\Invade\Tests;

class SuperclassExample
{
    private string $superclassPrivateProperty = 'superclassPrivateValue';

    private function superclassPrivateMethod(): string
    {
        return 'superclass private method';
    }
}
