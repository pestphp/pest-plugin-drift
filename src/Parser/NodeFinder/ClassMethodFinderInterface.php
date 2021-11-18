<?php

declare(strict_types=1);

namespace PestConverter\Parser\NodeFinder;

interface ClassMethodFinderInterface
{
    /**
     * Extract names from nodes.
     *
     * @param array<\PhpParser\Node> $nodes
     *
     * @return array<\PhpParser\Node\Stmt\ClassMethod>
     */
    public function find(array $nodes): array;
}
