<?php

declare(strict_types=1);

namespace PestConverter\Finder;

interface FinderInterface
{
    /**
     * Return test files present in directory.
     *
     * @return array<\PestConverter\Finder\File>
     */
    public function get(): array;

    /**
     * Count test files present in directory.
     */
    public function count(): int;
}
