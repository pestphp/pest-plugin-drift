<?php

declare(strict_types=1);

namespace Pest\Pestify\Converters;

use Pest\Pestify\Finder\FinderInterface;

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
    public function convert(FinderInterface $finder): void
    {
        foreach ($finder->get() as $file) {
            $this->fileConverter->convert($file);
        }
    }
}
