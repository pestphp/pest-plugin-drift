<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

use PhpParser\Node\Name;
use PhpParser\NodeFinder;

/**
 * @internal
 */
final class NameFinder extends AbstractNodeFinder implements NameFinderInterface
{
    public NodeFinder $nodeFinder;

    /**
     * Extract names from nodes.
     */
    public function find(array $nodes): array
    {
        /** @var array<int, Name>  $names */
        $names = $this->nodeFinder->findInstanceOf($nodes, Name::class);

        return $names;
    }
}
