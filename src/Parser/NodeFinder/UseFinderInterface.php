<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

/**
 * @internal
 */
interface UseFinderInterface
{
    /**
     * @param  array<\PhpParser\Node>  $nodes
     * @return array<\PhpParser\Node\Stmt\UseUse>
     */
    public function find(array $nodes): array;
}
