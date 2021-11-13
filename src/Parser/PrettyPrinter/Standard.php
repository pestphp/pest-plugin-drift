<?php

declare(strict_types=1);

namespace PestConverter\Parser\PrettyPrinter;

use PhpParser\Node;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\PrettyPrinter\Standard as BaseStandard;

final class Standard extends BaseStandard
{
    /**
     * @inheritDoc
     */
    protected function pStmt_Declare(Declare_ $node)
    {
        return parent::pStmt_Declare($node) . "\n";
    }

    /**
     * @inheritDoc
     */
    protected function pStmt_Expression(Expression $node)
    {
        $result = parent::pStmt_Expression($node);

        if ($this->shouldBreakLine($node)) {
            $result .= "\n";
        }

        return $result;
    }

    private function shouldBreakLine(Node $node): bool
    {
        if (! $node->hasAttribute('original_node')) {
            return false;
        }

        $originalNode = $node->getAttribute('original_node');

        $originalEndLine = $originalNode->getAttribute('endLine');

        if (! $originalNode->hasAttribute('next')) {
            return false;
        }

        $nextStartLine = $originalNode->getAttribute('next')->getAttribute('startLine');

        return $nextStartLine - $originalEndLine > 1;
    }
}
