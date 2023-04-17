<?php

declare(strict_types=1);

namespace Pest\Drift\Converters;

use Pest\Drift\Parser\PrettyPrinter\Standard;
use PhpParser\Lexer\Emulative;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\CloningVisitor;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\NodeVisitor\NodeConnectingVisitor;
use PhpParser\Parser\Php7;

/**
 * @internal
 */
final class CodeConverterFactory
{
    /**
     * Create CodeConverter class.
     */
    public function codeConverter(): CodeConverter
    {
        $visitors = require __DIR__.'/../../config/rules.php';

        $lexer = new Emulative([
            'usedAttributes' => [
                'comments',
                'startLine', 'endLine',
                'startTokenPos', 'endTokenPos',
            ],
        ]);

        $nodeTraverser = new NodeTraverser();
        $parser = new Php7($lexer);
        $prettyPrinter = new Standard();

        $nodeTraverser->addVisitor(new NodeConnectingVisitor());
        $nodeTraverser->addVisitor(new NameResolver(null, [
            'replaceNodes' => false,
        ]));
        $nodeTraverser->addVisitor(new CloningVisitor());

        foreach ($visitors as $visitor) {
            $nodeTraverser->addVisitor($visitor);
        }

        return new CodeConverter($parser, $nodeTraverser, $prettyPrinter, $lexer);
    }
}
