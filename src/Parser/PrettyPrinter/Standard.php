<?php

declare(strict_types=1);

namespace PestConverter\Parser\PrettyPrinter;

use PhpParser\Node;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Function_;
use PhpParser\PrettyPrinter\Standard as BaseStandard;

final class Standard extends BaseStandard
{
    /**
     * @inheritDoc
     */
    protected function p(Node $node, $parentFormatPreserved = false): string
    {
        $origNode = $node->getAttribute('origNode');

        if ($origNode === null) {
            return $this->pFallback($node);
        }

        $class = $node::class;
        if ($class !== $origNode::class) {
            return $this->pFallback($node);
        }

        $startPos = $origNode->getStartTokenPos();
        $endPos = $origNode->getEndTokenPos();

        if ($startPos < 0 || $endPos < 0) {
            return $this->pFallback($node);
        }

        $result = parent::p($node, $parentFormatPreserved);

        return LineBreaker::breakLineIfNecessary($node, $result);
    }

    /**
     * @inheritDoc
     */
    protected function pStmt_Expression(Expression $node)
    {
        $result = parent::pStmt_Expression($node);

        return LineBreaker::breakLineIfNecessary($node, $result);
    }

    /**
     * @inheritDoc
     */
    protected function pStmt_Function(Function_ $node)
    {
        $result = parent::pStmt_Function($node);

        return LineBreaker::breakLineIfNecessary($node, $result);
    }
}
