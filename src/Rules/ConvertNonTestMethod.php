<?php

declare(strict_types=1);

namespace Pest\Pestify\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;

/**
 * Replace non test class method with function.
 */
final class ConvertNonTestMethod extends AbstractConvertClassMethod
{
    protected function apply(ClassMethod $classMethod): int|Node|array|null
    {
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
            $classMethod->name,
            [
                'byRef' => $classMethod->byRef,
                'params' => $classMethod->params,
                'returnType' => $classMethod->returnType,
                'stmts' => $classMethod->stmts,
                'attrGroups' => $classMethod->attrGroups,
            ],
            $classMethod->getAttributes()
        );
    }
}
