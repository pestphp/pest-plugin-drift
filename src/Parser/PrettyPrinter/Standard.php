<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\PrettyPrinter;

use PhpParser\Node;
use PhpParser\Node\Stmt\Nop;
use PhpParser\PrettyPrinter\Standard as BaseStandard;

/**
 * @internal
 */
final class Standard extends BaseStandard
{
    /**
     * {@inheritDoc}
     */
    protected function p(Node $node, $parentFormatPreserved = false): string
    {
        $origNode = $node->getAttribute('origNode');

        if ($origNode === null) {
            return $this->pFallback($node);
        }

        assert($origNode instanceof Node);

        $class = $node::class;
        if ($class !== $origNode::class) {
            return $this->pFallback($node);
        }

        return parent::p($node, $parentFormatPreserved);
    }

    protected function pStmts(array $nodes, bool $indent = true): string
    {
        if ($indent) {
            $this->indent();
        }

        $result = '';
        foreach ($nodes as $node) {
            $comments = $node->getComments();
            if ($comments !== []) {
                $result .= $this->nl.$this->pComments($comments);
                if ($node instanceof Nop) {
                    continue;
                }
            }

            $result .= $this->nl.$this->p($node);
            $result = LineBreaker::breakLineIfNecessary($node, $result);
        }

        if ($indent) {
            $this->outdent();
        }

        return $result;
    }
}
