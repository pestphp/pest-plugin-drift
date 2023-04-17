<?php

declare(strict_types=1);

namespace Pest\Drift\Finder;

/**
 * @internal
 */
interface FinderInterface
{
    /**
     * Return test files present in directory.
     *
     * @return array<int, File>
     */
    public function get(): array;

    /**
     * Count test files present in directory.
     */
    public function count(): int;
}
