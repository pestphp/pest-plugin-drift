<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertIsCallable extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertIsCallable';
    }

    protected function expectationName(): string
    {
        return 'toBeCallable';
    }
}
