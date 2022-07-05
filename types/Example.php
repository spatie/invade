<?php

class Example
{
    public function __construct(
        private string $mySecret,
        protected int $myShared,
        public string $myExposed,
    ) {
    }

    public function getMySecret(): string
    {
        return $this->mySecret;
    }

    private function internalMethod(): int
    {
        return 2115;
    }
}
