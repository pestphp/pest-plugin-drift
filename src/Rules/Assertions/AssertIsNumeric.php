<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertIsNumeric extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertIsNumeric';
    }

    protected function expectationName(): string
    {
        return 'toBeNumeric';
    }
}
