<?php

namespace Spatie\Invade;

use InvalidArgumentException;
use ReflectionClass;

/**
 * @template T of object
 * @mixin T
 */
class Invader
{
    private ReflectionClass $reflectionClass;

    /**
     * @param T $obj
     */
    public function __construct(
        public object $obj
    ) {
        $this->reflectionClass = new ReflectionClass($this->obj);
    }

    public function __get(string $name): mixed
    {
        $property = $this->findPrivateProperty($this->reflectionClass, $name, $this->obj);

        return $property->getValue($this->obj);
    }

    public function __set(string $name, mixed $value): void
    {
        $property = $this->findPrivateProperty($this->reflectionClass, $name, $this->obj);

        $property->setValue($this->obj, $value);
    }

    public function __call(string $name, array $params = []): mixed
    {
        $method = $this->findPrivateMethod($this->reflectionClass, $name, $this->obj);

        return $method->invoke($this->obj);
    }

    /**
     * It recursively searches for a method name within the class and its parent classes.
     *
     * @param ReflectionClass $class
     * @param string $methodName
     * @param object $obj
     *
     * @return \ReflectionMethod
     */
    function findPrivateMethod(ReflectionClass $class, string $methodName, object $obj): \ReflectionMethod
    {
        $parentClass = $class->getParentClass();

        // Check if the method exists in the current class, and return accessible method.
        if ($class->hasMethod($methodName)) {
            $method = $class->getMethod($methodName);
            $method->setAccessible(true);
            return $method;
        }

        // If the method does not exist, check the parent class
        if (false !== $parentClass) {
            return self::findPrivateMethod($parentClass, $methodName, $obj);
        }

        // Requested method not found in class hierarchy
        throw new InvalidArgumentException("Method {$methodName} not found in class hierarchy");
    }

    /**
     * It recursively searches for a property within the class and its parent classes.
     *
     * @param ReflectionClass $class
     * @param string $propertyName
     * @param object $obj
     *
     * @return \ReflectionProperty
     */
    function findPrivateProperty(ReflectionClass $class, string $propertyName, object $obj): \ReflectionProperty
    {
        $parentClass = $class->getParentClass();

        // Check if the property exists in the current class, and return accessible property.
        if ($class->hasProperty($propertyName)) {
            $property = $class->getProperty($propertyName);
            $property->setAccessible(true);

            return $property;
        }

        // If the property does not exist, check the parent class
        if (false !== $parentClass) {
            return self::findPrivateProperty($parentClass, $propertyName, $obj);
        }

        // Requested property not found in class hierarchy
        throw new InvalidArgumentException("Property {$propertyName} not found in class hierarchy");
    }
}
