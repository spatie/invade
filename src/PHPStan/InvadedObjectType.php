<?php

namespace Spatie\Invade\PHPStan;

use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Type\ObjectType;

class InvadedObjectType extends ObjectType
{
    public function __construct(
        private ObjectType $object,
    ) {
        parent::__construct($this->object->getClassName(), $this->object->getSubtractedType(), $this->object->getClassReflection());
    }

    public function getProperty(string $propertyName, ClassMemberAccessAnswerer $scope): PropertyReflection
    {
        return new InvadedPropertyReflection(parent::getProperty($propertyName, $scope));
    }

    public function getMethod(string $methodName, ClassMemberAccessAnswerer $scope): MethodReflection
    {
        return new InvadedMethodReflection(parent::getMethod($methodName, $scope));
    }
}
