<?php

namespace Spatie\Invade\PHPStan;

use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\Type;
use Spatie\Invade\Invader;

class InvadedObjectType extends GenericObjectType
{
    public function __construct(
        private Type $invaded,
    ) {
        parent::__construct(Invader::class, [$invaded]);
    }

    public function getProperty(string $propertyName, ClassMemberAccessAnswerer $scope): PropertyReflection
    {
        return new InvadedPropertyReflection($this->invaded->getProperty($propertyName, $scope));
    }

    public function getMethod(string $methodName, ClassMemberAccessAnswerer $scope): MethodReflection
    {
        return new InvadedMethodReflection($this->invaded->getMethod($methodName, $scope));
    }
}
