<?php

declare(strict_types=1);

namespace Pest\Pestify\Converters;

use PhpParser\Lexer\Emulative;
use PhpParser\NodeTraverserInterface;
use PhpParser\Parser;
use PhpParser\PrettyPrinterAbstract;

/**
 * @internal
 */
final class CodeConverter
{
    public function __construct(private readonly Parser $parser, private readonly NodeTraverserInterface $traverser, private readonly PrettyPrinterAbstract $prettyPrinter, private readonly Emulative $lexer)
    {
    }

    /**
     * Convert the code content.
     */
    public function convert(string $code): string
    {
        $currentStatements = $this->parser->parse($code);

        $oldTokens = $this->lexer->getTokens();

        if (is_null($currentStatements)) {
            throw new \Exception('The parser was unable to recover from an error.');
        }

        $newStatements = $this->traverser->traverse($currentStatements);

        return $this->prettyPrinter->printFormatPreserving($newStatements, $currentStatements, $oldTokens);
    }
}
