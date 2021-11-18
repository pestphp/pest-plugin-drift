<?php

declare(strict_types=1);

namespace PestConverter\Parser\NodeFinder;

use PhpParser\Node\Name;

final class NameFinder extends AbstractNodeFinder implements NameFinderInterface
{
    /**
     * Extract names from nodes.
     */
    public function find(array $nodes): array
    {
        /** @var array<Name> */
        return $this->nodeFinder->findInstanceOf($nodes, Name::class);
    }
}
