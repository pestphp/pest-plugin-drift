<?php

declare(strict_types=1);

namespace PestConverter\Parser\NodeFinder;

interface NonTestMethodFinderInterface
{
    /**
     * Get the names for which they are missing a use
     *
     * @param array<\PhpParser\Node> $nodes
     *
     * @return array<\PhpParser\Node\Stmt\ClassMethod>
     */
    public function find(array $nodes): array;
}
