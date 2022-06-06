<?php

use Spatie\Invade\Invader;
use function PHPStan\Testing\assertType;

$example = new Example("password", 42, "Pestival");
$invaded = new Invader($example);

assertType(Invader::class . '<' . Example::class . '>', $invaded);
assertType('string', $invaded->myExposed);
assertType('int', $invaded->myShared);
assertType('string', $invaded->mySecret);
