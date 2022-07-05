<?php

namespace Spatie\Invade\PHPStan;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\Type;

class InvadeReturnTypeExtension implements DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(FunctionReflection $functionReflection): bool
    {
        return $functionReflection->getName() === 'invade';
    }

    public function getTypeFromFunctionCall(FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope): ?Type
    {
        $args = $functionCall->getArgs();
        if (! isset($args[0])) {
            return null;
        }

        $invaded = $scope->getType($args[0]->value);

        if (! $invaded instanceof ObjectType) {
            return new InvadedObjectType(new ObjectWithoutClassType());
        }

        return new InvadedObjectType($invaded);
    }
}
