<?php

declare(strict_types=1);

namespace PestConverter\Converters;

use PestConverter\Parser\PrettyPrinter\Standard;
use PestConverter\Parser\Visitors\OriginalNodeVisitor;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\NodeVisitor\NodeConnectingVisitor;
use PhpParser\ParserFactory;

final class CodeConverterFactory
{
    /**
     * Create CodeConverter class.
     */
    public function codeConverter(): CodeConverter
    {
        $visitors = require __DIR__ . '/../../config/rules.php';

        $nodeTraverser = new NodeTraverser();
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $prettyPrinter = new Standard();

        $nodeTraverser->addVisitor(new NodeConnectingVisitor());
        $nodeTraverser->addVisitor(new NameResolver());
        $nodeTraverser->addVisitor(new OriginalNodeVisitor());

        foreach ($visitors as $visitor) {
            $nodeTraverser->addVisitor($visitor);
        }

        return new CodeConverter($parser, $nodeTraverser, $prettyPrinter);
    }
}
