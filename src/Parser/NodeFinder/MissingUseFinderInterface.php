<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

interface MissingUseFinderInterface
{
    /**
     * Get the names for which they are missing a use
     *
     * @param  array<int, \PhpParser\Node>  $nodes
     * @return array<int, \PhpParser\Node\Name>
     */
    public function find(array $nodes): array;
}
