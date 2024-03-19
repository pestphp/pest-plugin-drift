<?php

declare(strict_types=1);

namespace Pest\Drift\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\UseItem;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

/**
 * @internal
 */
abstract class AbstractRemoveUse extends NodeVisitorAbstract
{
    /**
     * @var array<string>
     */
    private array $useToRemove = [];

    /**
     * {@inheritDoc}
     */
    public function beforeTraverse(array $nodes): void
    {
        $this->useToRemove = $this->useToRemove($nodes);
    }

    /**
     * {@inheritDoc}
     */
    public function leaveNode(Node $node)
    {
        if (! $node instanceof Use_) {
            return null;
        }

        // Filter use to remove.
        $node->uses = array_filter(
            $node->uses,
            fn (UseItem $use): bool => ! in_array($use->name->getLast(), $this->useToRemove, true) && $use->name->isQualified()
        );

        // Remove unnecessary use.
        if ($node->uses === []) {
            return NodeTraverser::REMOVE_NODE;
        }

        return $node;
    }

    /**
     * Get use to remove.
     *
     * @param  array<int, Node>  $nodes
     * @return array<int, string>
     */
    abstract protected function useToRemove(array $nodes): array;
}
