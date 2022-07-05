<?php

use Spatie\Invade\Invader;
use function PHPStan\Testing\assertType;

$example = new Example("password", 42, "Pestival");
$invaded = invade($example);

assertType(Invader::class . '<' . Example::class . '>', $invaded);
assertType('string', $invaded->myExposed);
assertType('int', $invaded->myShared);
assertType('string', $invaded->mySecret);
assertType('int', $invaded->internalMethod());

$invaded = getInvaded();

assertType(Invader::class . '<' . Example::class . '>', $invaded);
assertType('string', $invaded->myExposed);
assertType('int', $invaded->myShared);
assertType('string', $invaded->mySecret);
assertType('int', $invaded->internalMethod());

assertType(Invader::class . '<object>', invade(getMixed()));

function getMixed(): mixed
{
    return null;
}

/**
 * @return Invader<Example>
 */
function getInvaded(): Invader
{
    return invade(new Example("password", 42, "Pestival"));
}
