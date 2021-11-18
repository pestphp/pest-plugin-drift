<?php

declare(strict_types=1);

namespace PestConverter\Parser\NodeFinder;

use PhpParser\Node\Stmt\UseUse;

final class UseFinder extends AbstractNodeFinder implements UseFinderInterface
{
    /**
     * Extract uses from nodes.
     */
    public function find(array $nodes): array
    {
        /** @var array<UseUse> */
        return $this->nodeFinder->findInstanceOf($nodes, UseUse::class);
    }
}
