<?php

declare(strict_types=1);

namespace Pest\Drift\Finder;

use Symfony\Component\Finder\SplFileInfo;

/**
 * @internal
 */
final class File implements FileInterface
{
    /**
     * Creates a new file instance.
     */
    public function __construct(private readonly SplFileInfo $splFileInfo)
    {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function getBasename(string $suffix = ''): string
    {
        return $this->splFileInfo->getBasename($suffix);
    }

    /**
     * {@inheritDoc}
     */
    public function getContents(): string
    {
        return $this->splFileInfo->getContents();
    }

    /**
     * {@inheritDoc}
     */
    public function getRelativePath(): string
    {
        return $this->splFileInfo->getRelativePath();
    }

    /**
     * {@inheritDoc}
     */
    public function getRealPath(): string
    {
        return $this->splFileInfo->getRealPath();
    }
}
