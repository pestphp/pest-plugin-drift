<?php

declare(strict_types=1);

namespace Pest\Drift\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

/**
 * @internal
 */
final class RemoveProperties extends NodeVisitorAbstract
{
    /**
     * {@inheritDoc}
     */
    public function leaveNode(Node $node): ?int
    {
        if ($node instanceof Property) {
            return NodeTraverser::REMOVE_NODE;
        }

        return null;
    }
}
