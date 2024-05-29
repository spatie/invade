<?php

namespace Spatie\Invade\Tests;

class Base
{
    private string $basePrivateProperty = 'basePrivateValue';

    private function basePrivateMethod(): string {
        return 'base private method';
    }
}
