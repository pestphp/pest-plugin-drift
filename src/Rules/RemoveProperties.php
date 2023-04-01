<?php

declare(strict_types=1);

namespace Pest\Pestify\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

/**
 * Remove unnecessary properties.
 */
final class RemoveProperties extends NodeVisitorAbstract
{
    /**
     * {@inheritDoc}
     */
    public function leaveNode(Node $node)
    {
        if ($node instanceof Property) {
            return NodeTraverser::REMOVE_NODE;
        }
    }
}
