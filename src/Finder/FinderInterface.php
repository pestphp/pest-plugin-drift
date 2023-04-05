<?php

declare(strict_types=1);

namespace Pest\Pestify\Finder;

/**
 * @internal
 */
interface FinderInterface
{
    /**
     * Return test files present in directory.
     *
     * @return array<\Pest\Pestify\Finder\File>
     */
    public function get(): array;

    /**
     * Count test files present in directory.
     */
    public function count(): int;
}
