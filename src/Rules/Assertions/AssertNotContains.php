<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertNotContains extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertNotContains';
    }

    protected function expectationName(): string
    {
        return 'toContain';
    }

    protected function isNegative(): bool
    {
        return true;
    }
}
