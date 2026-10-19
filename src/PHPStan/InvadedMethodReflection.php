<?php

namespace Spatie\Invade\PHPStan;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptor;
use PHPStan\TrinaryLogic;
use PHPStan\Type\StaticType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeTraverser;

/**
 * The invaded class's own method, reported as public. Visibility is the one thing the bound
 * closure changes: parameters, return type and throws stay the real method's, so a wrong
 * argument or a wrong assumption about the return value still fails.
 */
class InvadedMethodReflection implements MethodReflection
{
    public function __construct(
        private MethodReflection $method,
        private ClassReflection $invaded,
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

    public function getDeclaringClass(): ClassReflection
    {
        return $this->method->getDeclaringClass();
    }

    public function isStatic(): bool
    {
        return $this->method->isStatic();
    }

    public function getName(): string
    {
        return $this->method->getName();
    }

    /**
     * This wrapper rather than the real prototype, so making the method public here does not
     * read as an invalid visibility change against the class it was declared in.
     */
    public function getPrototype(): ClassMemberReflection
    {
        return $this;
    }

    /** @return array<int, ParametersAcceptor> */
    public function getVariants(): array
    {
        return array_map(fn (ParametersAcceptor $variant) => new FunctionVariant(
            $variant->getTemplateTypeMap(),
            $variant->getResolvedTemplateTypeMap(),
            $variant->getParameters(),
            $variant->isVariadic(),
            TypeTraverser::map($variant->getReturnType(), function (Type $type, callable $traverse): Type {
                if ($type instanceof StaticType) {
                    return $type->changeBaseClass($this->invaded)->getStaticObjectType();
                }

                return $traverse($type);
            }),
        ), $this->method->getVariants());
    }

    public function getDocComment(): ?string
    {
        return $this->method->getDocComment();
    }

    public function isDeprecated(): TrinaryLogic
    {
        return $this->method->isDeprecated();
    }

    public function getDeprecatedDescription(): ?string
    {
        return $this->method->getDeprecatedDescription();
    }

    public function isFinal(): TrinaryLogic
    {
        return $this->method->isFinal();
    }

    public function isInternal(): TrinaryLogic
    {
        return $this->method->isInternal();
    }

    public function getThrowType(): ?Type
    {
        return $this->method->getThrowType();
    }

    public function hasSideEffects(): TrinaryLogic
    {
        return $this->method->hasSideEffects();
    }
}
