<?php

namespace Spatie\Invade\PHPStan;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\Php\PhpPropertyReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;

/**
 * The invaded class's own property, reported as public. Visibility is the only thing that
 * changes: the declared type is kept, so a read still carries the real type and a write is
 * still checked against it.
 */
class InvadedPropertyReflection implements PropertyReflection
{
    public function __construct(
        private PhpPropertyReflection $property,
    ) {
    }

    public function isPrivate(): bool
    {
        return false;
    }

    public function isPublic(): bool
    {
        return true;
    }

    public function isReadable(): bool
    {
        return $this->property->isReadable();
    }

    public function isWritable(): bool
    {
        if ($this->property->isReadOnly()) {
            return false;
        }

        return $this->property->isWritable();
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->property->getDeclaringClass();
    }

    public function isStatic(): bool
    {
        return $this->property->isStatic();
    }

    public function getDocComment(): ?string
    {
        return $this->property->getDocComment();
    }

    public function getReadableType(): Type
    {
        return $this->property->getReadableType();
    }

    public function getWritableType(): Type
    {
        return $this->property->getWritableType();
    }

    public function canChangeTypeAfterAssignment(): bool
    {
        return $this->property->canChangeTypeAfterAssignment();
    }

    public function isDeprecated(): TrinaryLogic
    {
        return $this->property->isDeprecated();
    }

    public function getDeprecatedDescription(): ?string
    {
        return $this->property->getDeprecatedDescription();
    }

    public function isInternal(): TrinaryLogic
    {
        return $this->property->isInternal();
    }
}
