<?php

declare(strict_types=1);

namespace Pest\Pestify\Rules\Assertions;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;

final class AssertionToNegativeExpectation extends AbstractAssertionToExpectation
{
    protected function buildExpect(MethodCall $methodCall): Expr
    {
        return new PropertyFetch(parent::buildExpect($methodCall), 'not');
    }
}
