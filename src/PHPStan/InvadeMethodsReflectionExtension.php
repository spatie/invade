<?php

namespace Spatie\Invade\PHPStan;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use PHPStan\ShouldNotHappenException;

class InvadeMethodsReflectionExtension implements MethodsClassReflectionExtension
{
    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        $invaded = InvadedClass::of($classReflection);

        if ($invaded === null || ! $invaded->hasNativeMethod($methodName)) {
            return false;
        }

        return InvadedClass::isReachableFrom($invaded->getNativeMethod($methodName), $invaded);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $invaded = InvadedClass::of($classReflection) ?? throw new ShouldNotHappenException();

        return new InvadedMethodReflection($invaded->getNativeMethod($methodName), $invaded);
    }
}
