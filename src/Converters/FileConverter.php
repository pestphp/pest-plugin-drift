<?php

declare(strict_types=1);

namespace PestConverter\Converters;

use PestConverter\Finder\FileInterface;

final class FileConverter
{
    private CodeConverter $codeConverter;
    private string $outputDir;

    public function __construct(CodeConverter $codeConverter, string $outputDir)
    {
        $this->codeConverter = $codeConverter;
        $this->outputDir = $outputDir;
    }

    /**
     * Convert the content of the file.
     */
    public function convert(FileInterface $file): void
    {
        file_put_contents(
            $this->resolveOutputPath($file),
            $this->codeConverter->convert($file->getContents())
        );
    }

    /**
     * Get the output path.
     */
    private function resolveOutputPath(FileInterface $file): string
    {
        $outputDir = $this->outputDir;

        if ($file->getRelativePath()) {
            $outputDir = $this->outputDir . '/' . $file->getRelativePath();
        }

        if (! file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        return $outputDir . '/' . $file->getBasename();
    }
}
