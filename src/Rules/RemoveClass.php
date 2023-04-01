<?php

declare(strict_types=1);

namespace Pest\Pestify\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeVisitorAbstract;

/**
 * Extract the content of the class and remove it.
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

        return $node->stmts;
    }
}
