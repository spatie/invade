<?php

namespace Spatie\Invade\Tests;

class SuperclassExample
{
    private string $superclassPrivateProperty = 'superclassPrivateValue';

    private function superclassPrivateMethod(): string
    {
        return 'superclass private method';
    }

    private function superclassPrivateMethodWithParams(string $firstParam, int $secondParam): string
    {
        return 'superclass private method with params where first param: '. $firstParam . ' and second param: '. $secondParam;
    }
}
