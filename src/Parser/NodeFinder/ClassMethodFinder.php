<?php

declare(strict_types=1);

namespace PestConverter\Parser\NodeFinder;

use PhpParser\Node\Stmt\ClassMethod;

final class ClassMethodFinder extends AbstractNodeFinder implements ClassMethodFinderInterface
{
    /**
     * Extract names from nodes.
     */
    public function find(array $nodes): array
    {
        /** @var array<ClassMethod> */
        return $this->nodeFinder->findInstanceOf($nodes, ClassMethod::class);
    }
}
