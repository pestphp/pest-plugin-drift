<?php

declare(strict_types=1);

namespace PestConverter\Parser\NodeFinder;

use PhpParser\Node\Stmt\UseUse;

final class MissingUseFinder implements MissingUseFinderInterface
{
    public function __construct(
        private UseFinder $useFinder,
        private NameFinder $nameFinder,
    ) {
    }

    public function find(array $nodes): array
    {
        $uses = array_map(function (UseUse $useUse) {
            return $useUse->name->toString();
        }, $this->useFinder->find($nodes));

        $names = $this->nameFinder->find($nodes);

        $namesWithMissingUse = [];

        foreach ($names as $name) {
            if (! $name->hasAttribute('resolvedName') || $name->isFullyQualified()) {
                continue;
            }

            $resolvedName = $name->getAttribute('resolvedName');

            if (in_array($resolvedName->toString(), $uses) || count($resolvedName->parts) === 1) {
                continue;
            }

            if (array_key_exists($name->toString(), $namesWithMissingUse)) {
                continue;
            }

            $namesWithMissingUse[$name->toString()] = $name;
        }

        return array_values($namesWithMissingUse);
    }
}
