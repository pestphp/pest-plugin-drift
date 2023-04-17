<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

use PhpParser\Node\Stmt\UseUse;
use PhpParser\NodeFinder;

/**
 * @internal
 */
final class UseFinder extends AbstractNodeFinder implements UseFinderInterface
{
    public NodeFinder $nodeFinder;

    /**
     * Extract uses from nodes.
     */
    public function find(array $nodes): array
    {
        /** @var array<int, UseUse>  $uses */
        $uses = $this->nodeFinder->findInstanceOf($nodes, UseUse::class);

        return $uses;
    }
}
