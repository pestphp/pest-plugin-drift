<?php

declare(strict_types=1);

namespace PestConverter\Parser\PrettyPrinter;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Function_;
use PhpParser\PrettyPrinter\Standard as BaseStandard;

final class Standard extends BaseStandard
{
    /**
     * Pretty prints a node.
     *
     * This method also handles formatting preservation for nodes.
     *
     * @param Node $node Node to be pretty printed
     * @param bool $parentFormatPreserved Whether parent node has preserved formatting
     *
     * @return string Pretty printed node
     */
    protected function p(Node $node, $parentFormatPreserved = false): string
    {
        $origNode = $node->getAttribute('origNode');

        if (null === $origNode) {
            return $this->pFallback($node);
        }

        $class = \get_class($node);
        if ($class !== \get_class($origNode)) {
            return $this->pFallback($node);
        }

        $startPos = $origNode->getStartTokenPos();
        $endPos = $origNode->getEndTokenPos();

        if ($startPos < 0 || $endPos < 0) {
            return $this->pFallback($node);
        }

        $result = parent::p($node, $parentFormatPreserved);

        if ($this->shouldBreakLine($node)) {
            $result .= "\n";
        }

        return $result;
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

    protected function pStmt_Function(Function_ $node)
    {
        $result = parent::pStmt_Function($node);

        if ($this->shouldBreakLine($node)) {
            $result .= "\n";
        }

        return $result;
    }

    private function shouldBreakLine(Node $node): bool
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
