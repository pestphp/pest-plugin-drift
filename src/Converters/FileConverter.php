<?php

declare(strict_types=1);

namespace Pest\Pestify\Converters;

use Exception;
use Pest\Pestify\Finder\FileInterface;

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
     * Convert the content of the file.
     *
     * @throws Exception
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

        if ($file->getRelativePath() !== '' && $file->getRelativePath() !== '0') {
            $outputDir = $this->outputDir.'/'.$file->getRelativePath();
        }

        if (! file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        return $outputDir.'/'.$file->getBasename();
    }
}
