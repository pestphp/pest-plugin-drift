<?php

declare(strict_types=1);

namespace Pest\Drift\Parser\NodeFinder;

use PhpParser\NodeFinder;

/**
 * @internal
 */
abstract class AbstractNodeFinder
{
    /**
     * Creates a new node finder instance.
     */
    public function __construct(
        protected NodeFinder $nodeFinder,
    ) {
        //
    }
}
