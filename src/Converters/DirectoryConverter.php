<?php

declare(strict_types=1);

namespace PestConverter\Converters;

use PestConverter\Finder\FinderInterface;

final class DirectoryConverter
{
    private FileConverter $fileConverter;

    public function __construct(FileConverter $fileConverter)
    {
        $this->fileConverter = $fileConverter;
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
