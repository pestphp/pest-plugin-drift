<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;

/**
 * @internal
 */
interface NonTestMethodFinderInterface
{
    /**
     * Get the names for which they are missing a use
     *
     * @param  array<Node>  $nodes
     * @return array<ClassMethod>
     */
    public function find(array $nodes): array;
}
