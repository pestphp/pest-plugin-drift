<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertNotEmpty extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertNotEmpty';
    }

    protected function expectationName(): string
    {
        return 'toBeEmpty';
    }

    protected function isNegative(): bool
    {
        return true;
    }
}
