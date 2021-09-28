<?php

declare(strict_types=1);

namespace PestConverter\Parser\Visitors;

use PhpParser\Node;
use PhpParser\Node\Stmt\Expression;
use PhpParser\NodeVisitorAbstract;

final class OriginalNodeVisitor extends NodeVisitorAbstract
{
    /**
     * @inheritDoc
     */
    public function leaveNode(Node $node)
    {
        if (! $node instanceof Expression) {
            return null;
        }

        $node->setAttribute('original_node', $node);

        return $node;
    }
}
