<?php

declare(strict_types=1);

namespace PestConverter\Parser\PrettyPrinter;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;

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

        $nextStartLine = $node->getAttribute('next')->getAttribute('startLine');

        return $nextStartLine - $endLine > 1;
    }
}
