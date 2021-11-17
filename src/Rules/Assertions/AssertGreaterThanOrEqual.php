<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertGreaterThanOrEqual extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertGreaterThanOrEqual';
    }

    protected function expectationName(): string
    {
        return 'toBeGreaterThanOrEqual';
    }
}
