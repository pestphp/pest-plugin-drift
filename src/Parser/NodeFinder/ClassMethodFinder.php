<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeFinder;

/**
 * @internal
 */
final class ClassMethodFinder extends AbstractNodeFinder implements ClassMethodFinderInterface
{
    /**
     * The node finder instance.
     */
    public NodeFinder $nodeFinder;

    /**
     * Extract names from nodes.
     */
    public function find(array $nodes): array
    {
        /** @var array<int, ClassMethod>  $classMethods */
        $classMethods = $this->nodeFinder->findInstanceOf($nodes, ClassMethod::class);

        return $classMethods;
    }
}
