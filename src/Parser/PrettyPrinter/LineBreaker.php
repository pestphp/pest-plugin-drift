<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\PrettyPrinter;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;

/**
 * @internal
 */
final class LineBreaker
{
    /**
     * Add a breakline to the print if necessary.
     */
    public static function breakLineIfNecessary(Node $node, string $result): string
    {
        if (self::shouldBreakLine($node)) {
            $result .= "\n";
        }

        return $result;
    }

    /**
     * Check if a breakline should be added after the node.
     */
    public static function shouldBreakLine(Node $node): bool
    {
        $endLine = $node->getAttribute('endLine');

        if ($node->hasAttribute('parent') && $node->getAttribute('parent') instanceof Class_) {
            return true;
        }

        if (! $node->hasAttribute('next')) {
            return false;
        }

        $next = $node->getAttribute('next');

        assert($next instanceof Node);

        $nextStartLine = $next->getAttribute('startLine');

        return $nextStartLine - $endLine > 1;
    }
}
