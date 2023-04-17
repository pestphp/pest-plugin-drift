<?php

declare(strict_types=1);

namespace Pest\Drift\Converters;

use Pest\Drift\Finder\FinderInterface;

/**
 * @internal
 */
final class DirectoryConverter
{
    /**
     * Creates a new directory converter instance.
     */
    public function __construct(private readonly FileConverter $fileConverter)
    {
        //
    }

    /**
     * Convert the files returned by the finder.
     */
    public function convert(FinderInterface $finder, callable $callback): int
    {
        $changedCount = 0;

        foreach ($finder->get() as $file) {
            $changed = $this->fileConverter->convert($file);

            $callback($changed);

            if ($changed) {
                $changedCount++;
            }
        }

        return $changedCount;
    }
}
