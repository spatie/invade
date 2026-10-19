<?php

namespace Spatie\Invade\Types;

use function PHPStan\Testing\assertType;

use Spatie\Invade\Invader;
use Spatie\Invade\StaticInvader;

$example = new Example();

// The helper's return follows its argument, so member access is not also checked
// against StaticInvader, which has none of these members.
assertType('Spatie\Invade\Invader<Spatie\Invade\Types\Example>', invade($example));
assertType(StaticInvader::class, invade(Example::class));

// A private or protected member of the invaded class resolves with its real type.
assertType('string', invade($example)->privateProperty);
assertType('int', invade($example)->protectedProperty);
assertType('string', invade($example)->promotedProperty);
assertType('string', invade($example)->privateMethod('argument'));
assertType('int', invade($example)->protectedMethod());

// Constructing the Invader directly behaves the same.
assertType('string', (new Invader($example))->privateProperty);

// Writing a private property is allowed and type-checked.
invade($example)->privateProperty = 'another value';
/** @phpstan-ignore assign.propertyType (the declared type is kept, so a wrong write still fails) */
invade($example)->privateProperty = 1;

// A member the invaded class does not have is still an error.
/** @phpstan-ignore property.notFound (invade does not invent members) */
$missing = invade($example)->missingProperty;
/** @phpstan-ignore method.notFound (invade does not invent members) */
invade($example)->missingMethod();

// The real signature is kept, so a wrong argument still fails.
/** @phpstan-ignore argument.type (the real parameter type is kept) */
invade($example)->privateMethod(1);

// A private member declared on a parent is out of the closure's scope at runtime: reading one
// gives null and calling one fails, so the analyser must not accept either. See #33. The two
// identifiers differ because native reflection lists a parent's private method on the child but
// not its private property, so only the method reaches the `@mixin` fallback.
/** @phpstan-ignore property.notFound (a parent's private property is unreachable) */
$unreachableProperty = invade($example)->parentPrivateProperty;
/** @phpstan-ignore method.private (a parent's private method is unreachable) */
$unreachable = invade($example)->parentPrivateMethod();
