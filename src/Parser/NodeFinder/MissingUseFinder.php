<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

use PhpParser\Node\Name;
use PhpParser\Node\Stmt\GroupUse;
use PhpParser\Node\Stmt\UseUse;

/**
 * @internal
 */
final class MissingUseFinder implements MissingUseFinderInterface
{
    /**
     * Creates a new missing use finder instance.
     */
    public function __construct(
        private readonly UseFinder $useFinder,
        private readonly NameFinder $nameFinder,
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function find(array $nodes): array
    {
        $uses = array_map(function (UseUse $useUse): string {
            $parent = $useUse->getAttribute('parent');

            if ($parent instanceof GroupUse) {
                return $parent->prefix->toString().'\\'.$useUse->name->toString();
            }

            return $useUse->name->toString();
        }, $this->useFinder->find($nodes));

        $names = $this->nameFinder->find($nodes);

        $namesWithMissingUse = [];

        foreach ($names as $name) {

            if (! $name->hasAttribute('resolvedName')) {
                continue;
            }
            if ($name->isFullyQualified()) {
                continue;
            }
            $resolvedName = $name->getAttribute('resolvedName');
            assert($resolvedName instanceof Name);

            if (in_array($resolvedName->toString(), $uses, true)) {
                continue;
            }
            if ((is_countable($resolvedName->getParts()) ? count($resolvedName->getParts()) : 0) === 1) { // @phpstan-ignore-line
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
