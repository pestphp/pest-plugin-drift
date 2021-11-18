<?php

declare(strict_types=1);

namespace PestConverter\Parser\NodeFinder;

interface UseFinderInterface
{
    /**
     * @param array<\PhpParser\Node> $nodes
     *
     * @return array<\PhpParser\Node\Stmt\UseUse>
     */
    public function find(array $nodes): array;
}
