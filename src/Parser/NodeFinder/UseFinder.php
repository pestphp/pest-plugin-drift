<?php

declare(strict_types=1);

namespace Pest\Pestify\Parser\NodeFinder;

use PhpParser\Node\Stmt\UseUse;

final class UseFinder extends AbstractNodeFinder implements UseFinderInterface
{
    public $nodeFinder;

    /**
     * Extract uses from nodes.
     */
    public function find(array $nodes): array
    {
        return $this->nodeFinder->findInstanceOf($nodes, UseUse::class);
    }
}
