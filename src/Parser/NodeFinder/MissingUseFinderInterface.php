<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

use PhpParser\Node;
use PhpParser\Node\Name;

interface MissingUseFinderInterface
{
    /**
     * Get the names for which they are missing a use
     *
     * @param  array<int, Node>  $nodes
     * @return array<int, Name>
     */
    public function find(array $nodes): array;
}
