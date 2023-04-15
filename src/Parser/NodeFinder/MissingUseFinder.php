<?php

declare(strict_types=1);

namespace Pest\Pestify\Parser\NodeFinder;

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
        $uses = array_map(fn (UseUse $useUse): string => $useUse->name->toString(), $this->useFinder->find($nodes));

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
            if (in_array($resolvedName->toString(), $uses)) {
                continue;
            }
            if ((is_countable($resolvedName->parts) ? count($resolvedName->parts) : 0) === 1) {
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
