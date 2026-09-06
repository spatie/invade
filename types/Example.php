<?php

namespace Spatie\Invade\Types;

class ExampleParent
{
    private string $parentPrivateProperty = 'parent private value';

    public function parentSummary(): string
    {
        return $this->parentPrivateProperty . $this->parentPrivateMethod();
    }

    private function parentPrivateMethod(): string
    {
        return 'parent private return value';
    }
}

class Example extends ExampleParent
{
    private string $privateProperty = 'private value';

    protected int $protectedProperty = 1;

    public function __construct(
        private string $promotedProperty = 'promoted value',
    ) {
    }

    public function summary(): string
    {
        return $this->privateProperty
            . $this->promotedProperty
            . $this->protectedProperty
            . $this->privateMethod('argument')
            . $this->protectedMethod();
    }

    private function privateMethod(string $argument): string
    {
        return 'private return value ' . $argument;
    }

    protected function protectedMethod(): int
    {
        return 2115;
    }
}
