<?php

declare(strict_types=1);

namespace PestConverter\Parser\NodeFinder;

use PestConverter\Analyzer\ClassMethodAnalyzerInterface;
use PhpParser\Node\Stmt\ClassMethod;

final class NonTestMethodFinder implements NonTestMethodFinderInterface
{
    public function __construct(
        private ClassMethodFinderInterface $classMethodFinder,
        private ClassMethodAnalyzerInterface $classMethodAnalyzer,
    ) {
    }

    public function find(array $nodes): array
    {
        $classMethods = $this->classMethodFinder->find($nodes);

        return array_filter($classMethods, function (ClassMethod $classMethod) {
            return ! $this->classMethodAnalyzer->isLifecycleMethod($classMethod) && ! $this->classMethodAnalyzer->isTestMethod($classMethod);
        });
    }
}
