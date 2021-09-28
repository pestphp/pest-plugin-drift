<?php

declare(strict_types=1);

namespace PestConverter\Finder;

use Symfony\Component\Finder\Finder as BaseFinder;
use Symfony\Component\Finder\SplFileInfo;

final class Finder implements FinderInterface
{
    private BaseFinder $baseFinder;

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
     * @return array<\PestConverter\Finder\File>
     */
    public function get(): array
    {
        return array_map(static function (SplFileInfo $splFileInfo) {
            return new File($splFileInfo);
        }, iterator_to_array($this->baseFinder));
    }

    public function count(): int
    {
        return $this->baseFinder->count();
    }
}
