<?php

declare(strict_types=1);

namespace Pest\Drift\Finder;

use Symfony\Component\Finder\Finder as BaseFinder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @internal
 */
final class Finder implements FinderInterface
{
    /**
     * The base finder instance.
     */
    private readonly BaseFinder $baseFinder;

    /**
     * Creates a new finder instance.
     *
     * @param  string|array<int, string>  $in
     * @param  string|array<int, string>  $not
     */
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
     * {@inheritDoc}
     */
    public function get(): array
    {
        return array_values(array_map(static fn (SplFileInfo $splFileInfo): File => new File($splFileInfo), iterator_to_array($this->baseFinder)));
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return $this->baseFinder->count();
    }
}
