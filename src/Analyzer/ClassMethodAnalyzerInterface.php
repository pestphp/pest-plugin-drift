<?php

declare(strict_types=1);

namespace PestConverter\Analyzer;

use PhpParser\Node\Stmt\ClassMethod;

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
}
