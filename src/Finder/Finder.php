<?php

declare(strict_types=1);

namespace Pest\Pestify\Finder;

use Symfony\Component\Finder\Finder as BaseFinder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @internal
 */
final class Finder implements FinderInterface
{
    private readonly BaseFinder $baseFinder;

    public function __construct(string|array $in, string|array $not = [])
    {
        $this->baseFinder = (new BaseFinder())
            ->files()
            ->name('*Test.php')
            ->exclude('vendor')
            ->in($in)
            ->notPath($not);
    }

    /**
     * Return files in selected directories.
     *
     * @return array<\Pest\Pestify\Finder\File>
     */
    public function get(): array
    {
        return array_map(static fn (SplFileInfo $splFileInfo): \Pest\Pestify\Finder\File => new File($splFileInfo), iterator_to_array($this->baseFinder));
    }

    public function count(): int
    {
        return $this->baseFinder->count();
    }
}
