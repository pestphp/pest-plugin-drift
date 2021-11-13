<?php

declare(strict_types=1);

namespace PestConverter\Rules;

use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;
use PhpParser\NodeFinder;
use PhpParser\NodeVisitorAbstract;

final class AddMissingUse extends NodeVisitorAbstract
{
    public function afterTraverse(array $nodes)
    {
        $nodeFinder = new NodeFinder();

        /** @var array<UseUse> */
        $useUses = $nodeFinder->findInstanceOf($nodes, UseUse::class);

        // $useIndex = array_search($useUses[0], $nodes);
        $useIndex = 1;

        $useString = array_map(static function (UseUse $use) {
            return $use->name->toString();
        }, $useUses);

        /** @var array<Name> */
        $names = $nodeFinder->findInstanceOf($nodes, Name::class);

        foreach ($names as $name) {
            if (! $name->hasAttribute('resolvedName') || $name->isFullyQualified()) {
                continue;
            }

            $resolvedName = $name->getAttribute('resolvedName');

            if (in_array($resolvedName->toString(), $useString) || 1 === count($resolvedName->parts)) {
                continue;
            }

            $useString[] = $resolvedName->toString();

            $use = new Use_([
                new UseUse($resolvedName),
            ]);

            array_splice($nodes, $useIndex, 0, [$use]);
        }

        return $nodes;
    }
}
