<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

use PhpParser\Node;
use PhpParser\Node\Name;

/**
 * @internal
 */
interface NameFinderInterface
{
    /**
     * @param  array<Node>  $nodes
     * @return array<Name>
     */
    public function find(array $nodes): array;
}
