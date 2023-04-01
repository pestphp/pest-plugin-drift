<?php

declare(strict_types=1);

namespace Pest\Pestify\Parser\NodeFinder;

use PhpParser\Node\Name;

final class NameFinder extends AbstractNodeFinder implements NameFinderInterface
{
    public $nodeFinder;

    /**
     * Extract names from nodes.
     */
    public function find(array $nodes): array
    {
        return $this->nodeFinder->findInstanceOf($nodes, Name::class);
    }
}
