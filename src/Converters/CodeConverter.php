<?php

declare(strict_types=1);

namespace Pest\Drift\Converters;

use Pest\Drift\Exceptions\UnrecoverableException;
use PhpParser\NodeTraverserInterface;
use PhpParser\Parser;
use PhpParser\PrettyPrinterAbstract;

/**
 * @internal
 */
final class CodeConverter
{
    /**
     * Creates a new code converter instance.
     */
    public function __construct(
        private readonly Parser $parser,
        private readonly NodeTraverserInterface $traverser,
        private readonly PrettyPrinterAbstract $prettyPrinter
    ) {
        //
    }

    /**
     * Convert the code content.
     *
     * @throws UnrecoverableException
     */
    public function convert(string $code): string
    {
        $currentStatements = $this->parser->parse($code);

        $oldTokens = $this->parser->getTokens();

        if (is_null($currentStatements)) {
            throw new UnrecoverableException('The parser was unable to recover from an error.');
        }

        $newStatements = $this->traverser->traverse($currentStatements);

        return $this->prettyPrinter->printFormatPreserving($newStatements, $currentStatements, $oldTokens);
    }
}
