<?php

declare(strict_types=1);

namespace PestConverter\Parser\NodeFinder;

interface MissingUseFinderInterface
{
    /**
     * Get the names for which they are missing a use
     *
     * @param array<\PhpParser\Node> $nodes
     *
     * @return array<\PhpParser\Node\Name>
     */
    public function find(array $nodes): array;
}
