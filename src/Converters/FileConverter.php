<?php

declare(strict_types=1);

namespace Pest\Drift\Converters;

use Exception;
use Pest\Drift\Finder\FileInterface;

/**
 * @internal
 */
final class FileConverter
{
    /**
     * Creates a new file converter instance.
     */
    public function __construct(private readonly CodeConverter $codeConverter, private readonly string $outputDir)
    {
        //
    }

    /**
     * Convert the content of the file, and check if it has been converted.
     *
     * @throws Exception
     */
    public function convert(FileInterface $file): bool
    {
        file_put_contents(
            $this->resolveOutputPath($file),
            $convertedContents = $this->codeConverter->convert($originalContents = $file->getContents())
        );

        return $convertedContents !== $originalContents;
    }

    /**
     * Get the output path.
     */
    private function resolveOutputPath(FileInterface $file): string
    {
        $outputDir = $this->outputDir;

        if ($file->getRelativePath() !== '' && $file->getRelativePath() !== '0') {
            $outputDir = $this->outputDir.'/'.$file->getRelativePath();
        }

        if (! file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        return $outputDir.'/'.$file->getBasename();
    }
}
