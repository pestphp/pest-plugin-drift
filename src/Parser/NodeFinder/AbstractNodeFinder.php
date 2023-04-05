<?php

declare(strict_types=1);

namespace Pest\Pestify\Parser\NodeFinder;

use PhpParser\NodeFinder;

/**
 * @internal
 */
abstract class AbstractNodeFinder
{
    public function __construct(
        protected NodeFinder $nodeFinder,
    ) {
    }
}
