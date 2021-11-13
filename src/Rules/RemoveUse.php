<?php

declare(strict_types=1);

namespace PestConverter\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\TraitUse;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;
use PhpParser\NodeFinder;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

/**
 * Remove unnecessary use from test class.
 */
final class RemoveUse extends NodeVisitorAbstract
{
    private array $useToRemove = [];

    public function beforeTraverse(array $nodes): void
    {
        $nodeFinder = new NodeFinder();

        /** @var array<Class_> */
        $classesWithExtends = $nodeFinder->find($nodes, static fn (Node $node) => $node instanceof Class_ && $node->extends !== null);

        foreach ($classesWithExtends as $classWithExtends) {
            $this->useToRemove[] = $classWithExtends->extends?->toString();
        }

        /** @var array<TraitUse> */
        $traitsUse = $nodeFinder->findInstanceOf($nodes, TraitUse::class);

        foreach ($traitsUse as $traitUse) {
            foreach ($traitUse->traits as $trait) {
                $this->useToRemove[] = $trait->toString();
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function leaveNode(Node $node)
    {
        if (! $node instanceof Use_) {
            return null;
        }

        $node->uses = array_filter($node->uses, function (UseUse $use) {
            return ! in_array($use->name->getLast(), $this->useToRemove) && $use->name->isQualified();
        });

        if (count($node->uses) === 0) {
            return NodeTraverser::REMOVE_NODE;
        }

        return $node;
    }
}
