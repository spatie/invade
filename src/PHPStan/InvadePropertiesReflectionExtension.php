<?php

namespace Spatie\Invade\PHPStan;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\PropertiesClassReflectionExtension;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\ShouldNotHappenException;

class InvadePropertiesReflectionExtension implements PropertiesClassReflectionExtension
{
    public function hasProperty(ClassReflection $classReflection, string $propertyName): bool
    {
        $invaded = InvadedClass::of($classReflection);

        if ($invaded === null || ! $invaded->hasNativeProperty($propertyName)) {
            return false;
        }

        return InvadedClass::isReachableFrom($invaded->getNativeProperty($propertyName), $invaded);
    }

    public function getProperty(ClassReflection $classReflection, string $propertyName): PropertyReflection
    {
        $invaded = InvadedClass::of($classReflection) ?? throw new ShouldNotHappenException();

        return new InvadedPropertyReflection($invaded->getNativeProperty($propertyName));
    }
}
