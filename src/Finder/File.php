<?php

declare(strict_types=1);

namespace PestConverter\Finder;

use Symfony\Component\Finder\SplFileInfo;

final class File implements FileInterface
{
    private SplFileInfo $splFileInfo;

    public function __construct(SplFileInfo $splFileInfo)
    {
        $this->splFileInfo = $splFileInfo;
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
