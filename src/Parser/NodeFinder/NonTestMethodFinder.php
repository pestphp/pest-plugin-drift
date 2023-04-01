<?php

declare(strict_types=1);

namespace Pest\Pestify\Parser\NodeFinder;

use Pest\Pestify\Analyzer\ClassMethodAnalyzerInterface;
use PhpParser\Node\Stmt\ClassMethod;

final class NonTestMethodFinder implements NonTestMethodFinderInterface
{
    public function __construct(
        private readonly ClassMethodFinderInterface $classMethodFinder,
        private readonly ClassMethodAnalyzerInterface $classMethodAnalyzer,
    ) {
    }

    public function find(array $nodes): array
    {
        $classMethods = $this->classMethodFinder->find($nodes);

        return array_filter($classMethods, fn (ClassMethod $classMethod): bool => ! $this->classMethodAnalyzer->isLifecycleMethod($classMethod) && ! $this->classMethodAnalyzer->isTestMethod($classMethod));
    }
}
