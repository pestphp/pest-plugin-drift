<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;

/**
 * @internal
 */
interface ClassMethodFinderInterface
{
    /**
     * Extract names from nodes.
     *
     * @param  array<int, Node>  $nodes
     * @return array<int, ClassMethod>
     */
    public function find(array $nodes): array;
}
