<?php

declare(strict_types=1);

namespace PestConverter\Parser\NodeFinder;

use PhpParser\NodeFinder;

abstract class AbstractNodeFinder
{
    public function __construct(
        protected NodeFinder $nodeFinder,
    ) {
    }
}
