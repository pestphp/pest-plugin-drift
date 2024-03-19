<?php

declare(strict_types=1);

namespace Pest\Drift\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeVisitorAbstract;

/**
 * @internal
 */
final class RemoveClass extends NodeVisitorAbstract
{
    /**
     * {@inheritDoc}
     */
    public function leaveNode(Node $node)
    {
        if (! $node instanceof Class_) {
            return null;
        }

        $parent = $node->getAttribute('parent');

        if ($parent !== null && ! $parent instanceof Node\Stmt\Namespace_ && ! $parent instanceof Node\Stmt\Use_) {
            return $node;
        }

        return $node->stmts;
    }
}
