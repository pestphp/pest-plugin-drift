<?php

declare(strict_types=1);

namespace PestConverter\Converters;

use PhpParser\Lexer\Emulative;
use PhpParser\NodeTraverserInterface;
use PhpParser\Parser;
use PhpParser\PrettyPrinterAbstract;

final class CodeConverter
{
    private Parser $parser;
    private NodeTraverserInterface $traverser;
    private PrettyPrinterAbstract $prettyPrinter;
    private Emulative $lexer;

    public function __construct(Parser $parser, NodeTraverserInterface $traverser, PrettyPrinterAbstract $prettyPrinter, Emulative $lexer)
    {
        $this->parser = $parser;
        $this->prettyPrinter = $prettyPrinter;
        $this->traverser = $traverser;
        $this->lexer = $lexer;
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
