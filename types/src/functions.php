<?php

use Spatie\Invade\Invader;
use function PHPStan\Testing\assertType;

$example = new Example("password", 42, "Pestival");

assertType(Invader::class . '<' . Example::class . '>', invade($example));
