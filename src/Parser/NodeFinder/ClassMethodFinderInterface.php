<?php

declare(strict_types=1);

namespace Pest\Pestify\Parser\NodeFinder;

/**
 * @internal
 */
interface ClassMethodFinderInterface
{
    /**
     * Extract names from nodes.
     *
     * @param  array<\PhpParser\Node>  $nodes
     * @return array<\PhpParser\Node\Stmt\ClassMethod>
     */
    public function find(array $nodes): array;
}
