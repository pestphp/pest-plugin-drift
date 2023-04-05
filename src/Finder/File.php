<?php

declare(strict_types=1);

namespace Pest\Pestify\Finder;

use Symfony\Component\Finder\SplFileInfo;

/**
 * @internal
 */
final class File implements FileInterface
{
    public function __construct(private readonly SplFileInfo $splFileInfo)
    {
    }

    public function getBasename(string $suffix = ''): string
    {
        return $this->splFileInfo->getBasename($suffix);
    }

    public function getContents(): string
    {
        return $this->splFileInfo->getContents();
    }

    public function getRelativePath(): string
    {
        return $this->splFileInfo->getRelativePath();
    }

    public function getRealPath(): string
    {
        return $this->splFileInfo->getRealPath();
    }
}
