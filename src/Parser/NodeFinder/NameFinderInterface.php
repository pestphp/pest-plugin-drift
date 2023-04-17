<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

/**
 * @internal
 */
interface NameFinderInterface
{
    /**
     * @param  array<\PhpParser\Node>  $nodes
     * @return array<\PhpParser\Node\Name>
     */
    public function find(array $nodes): array;
}
