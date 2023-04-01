<?php

declare(strict_types=1);

namespace Pest\Pestify\Parser\NodeFinder;

use PhpParser\Node\Stmt\ClassMethod;

final class ClassMethodFinder extends AbstractNodeFinder implements ClassMethodFinderInterface
{
    public $nodeFinder;

    /**
     * Extract names from nodes.
     */
    public function find(array $nodes): array
    {
        return $this->nodeFinder->findInstanceOf($nodes, ClassMethod::class);
    }
}
