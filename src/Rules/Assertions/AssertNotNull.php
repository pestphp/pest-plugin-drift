<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertNotNull extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertNotNull';
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
