<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertIsInt extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertIsInt';
    }

    protected function expectationName(): string
    {
        return 'toBeInt';
    }
}
