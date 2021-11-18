<?php

declare(strict_types=1);

namespace PestConverter\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

/**
 * Remove unnecessary use from test class.
 */
abstract class AbstractRemoveUse extends NodeVisitorAbstract
{
    /**
     * @var array<string>
     */
    private array $useToRemove = [];

    public function beforeTraverse(array $nodes): void
    {
        $this->useToRemove = $this->useToRemove($nodes);
    }

    /**
     * @inheritDoc
     */
    public function leaveNode(Node $node)
    {
        if (! $node instanceof Use_) {
            return null;
        }

        // Filter use to remove.
        $node->uses = array_filter($node->uses, function (UseUse $use) {
            return ! in_array($use->name->getLast(), $this->useToRemove) && $use->name->isQualified();
        });

        // Remove unnecessary use.
        if (count($node->uses) === 0) {
            return NodeTraverser::REMOVE_NODE;
        }

        return $node;
    }

    /**
     * Get use to remove.
     *
     * @return array<string>
     */
    abstract protected function useToRemove(array $nodes): array;
}
