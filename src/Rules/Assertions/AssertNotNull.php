<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

use PestConverter\Rules\AbstractAssertionToExpectation;
use PhpParser\Node\Arg;
use PhpParser\Node\VariadicPlaceholder;

final class AssertNotNull extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertNotNull';
    }

    /**
     * @inheritDoc
     */
    protected function actual(array $args): Arg|VariadicPlaceholder
    {
        return $args[0];
    }

    protected function expectationName(): string
    {
        return 'toBeNull';
    }

    protected function isNegative(): bool
    {
        return true;
    }
}
