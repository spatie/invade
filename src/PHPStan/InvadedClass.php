<?php

namespace Spatie\Invade\PHPStan;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use Spatie\Invade\Invader;

class InvadedClass
{
    /**
     * Resolve the `T` of an `Invader<T>` receiver: the class that was invaded.
     */
    public static function of(ClassReflection $classReflection): ?ClassReflection
    {
        $classReflection = $classReflection->getAncestorWithClassName(Invader::class);

        if ($classReflection === null) {
            return null;
        }

        $invaded = $classReflection->getActiveTemplateTypeMap()->getType('T');

        if ($invaded === null) {
            return null;
        }

        $reflections = $invaded->getObjectClassReflections();

        return count($reflections) === 1 ? $reflections[0] : null;
    }

    /**
     * `__get`, `__set` and `__call` bind their closure to the invaded object's own class, so a
     * private member declared on a parent is out of scope there: reading one gives null and
     * calling one fails, even though reflection reports the class as having it. See #33.
     */
    public static function isReachableFrom(ClassMemberReflection $member, ClassReflection $invaded): bool
    {
        return ! $member->isPrivate() || $member->getDeclaringClass()->getName() === $invaded->getName();
    }
}
