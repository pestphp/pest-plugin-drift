<?php

declare(strict_types=1);

namespace PestConverter\Rules;

use PestConverter\Parser\NodeFinder\MissingUseFinderInterface;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;
use PhpParser\NodeVisitorAbstract;

/**
 * Add missing uses.
 */
final class AddMissingUse extends NodeVisitorAbstract
{
    public function __construct(
        private MissingUseFinderInterface $missingUseFinder,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function afterTraverse(array $nodes)
    {
        $missingUses = $this->missingUseFinder->find($nodes);

        // Add missing uses.
        foreach ($missingUses as $missingUse) {
            $use = new Use_([
                new UseUse($missingUse->getAttribute('resolvedName')),
            ]);

            array_splice($nodes, 1, 0, [$use]);
        }

        return $nodes;
    }
}
