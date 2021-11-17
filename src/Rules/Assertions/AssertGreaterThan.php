<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertGreaterThan extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertGreaterThan';
    }

    protected function expectationName(): string
    {
        return 'toBeGreaterThan';
    }
}
