<?php

declare(strict_types=1);

namespace Pest\Pestify\Parser\NodeFinder;

use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeFinder;

/**
 * @internal
 */
final class ClassMethodFinder extends AbstractNodeFinder implements ClassMethodFinderInterface
{
    public NodeFinder $nodeFinder;

    /**
     * Extract names from nodes.
     */
    public function find(array $nodes): array
    {
        return $this->nodeFinder->findInstanceOf($nodes, ClassMethod::class);
    }
}
