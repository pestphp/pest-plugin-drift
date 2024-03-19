<?php

declare(strict_types=1);

namespace Pest\Drift\Rules;

use Pest\Drift\ValueObject\Node\AttributeKey;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Function_;

/**
 * @internal
 */
final class ConvertNonTestMethod extends AbstractConvertClassMethod
{
    protected function apply(ClassMethod $classMethod): int|Node|array|null
    {
        $isDataProvider = $classMethod->getAttribute(AttributeKey::IS_DATA_PROVIDER, false);

        if ($isDataProvider === true) {
            return $this->convertDataProviderMethod($classMethod);
        }

        return $this->convertClassMethod($classMethod);
    }

    /**
     * Filter methods to convert.
     */
    protected function filter(ClassMethod $classMethod): bool
    {
        if ($this->classMethodAnalyzer->isTestMethod($classMethod)) {
            return false;
        }

        return ! $this->classMethodAnalyzer->isLifecycleMethod($classMethod);
    }

    /**
     * Convert class method to function.
     */
    private function convertClassMethod(ClassMethod $classMethod): Function_
    {
        return new Function_(
            $classMethod->name->toString(),
            [
                'byRef' => $classMethod->byRef,
                'params' => $classMethod->params,
                'returnType' => $classMethod->returnType,
                'stmts' => $classMethod->stmts ?? [],
                'attrGroups' => $classMethod->attrGroups,
            ],
            $classMethod->getAttributes()
        );
    }

    private function convertDataProviderMethod(ClassMethod $classMethod): Expression
    {
        $methodName = $classMethod->name->toString();
        $attributes = $classMethod->getAttributes();

        $datasetCall = new FuncCall(
            new Name('dataset'),
            [
                new Arg(new String_($methodName)),
                new Arg(new Closure([
                    'stmts' => $classMethod->stmts ?? [],
                    'params' => $classMethod->getParams(),
                ])),
            ]
        );

        return new Expression($datasetCall, $attributes);
    }
}
