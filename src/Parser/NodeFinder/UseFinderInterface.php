<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

use PhpParser\Node;
use PhpParser\Node\Stmt\UseUse;

/**
 * @internal
 */
interface UseFinderInterface
{
    /**
     * @param  array<Node>  $nodes
     * @return array<UseUse>
     */
    public function find(array $nodes): array;
}
