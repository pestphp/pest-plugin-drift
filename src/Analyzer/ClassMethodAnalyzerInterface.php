<?php

declare(strict_types=1);

namespace Pest\Drift\Analyzer;

use PhpParser\Node\Stmt\ClassMethod;

/**
 * @internal
 */
interface ClassMethodAnalyzerInterface
{
    /**
     * Check if the class method is a lifecycle method.
     */
    public function isLifecycleMethod(ClassMethod $classMethod): bool;

    /**
     * Check if the class method is a test method.
     */
    public function isTestMethod(ClassMethod $classMethod): bool;

    /**
     * Reduce classMethod attrGroups and return an array with attrs names.
     *
     * @return string[][]
     */
    public function reduceAttrGroups(ClassMethod $classMethod): array;
}
