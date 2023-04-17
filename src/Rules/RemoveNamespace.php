<?php

declare(strict_types=1);

namespace Pest\Drift\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeVisitorAbstract;

/**
 * @internal
 */
final class RemoveNamespace extends NodeVisitorAbstract
{
    /**
     * {@inheritDoc}
     */
    public function leaveNode(Node $node)
    {
        if (! $node instanceof Namespace_) {
            return null;
        }

        return $node->stmts;
    }
}
