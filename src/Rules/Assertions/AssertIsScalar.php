<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertIsScalar extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertIsScalar';
    }

    protected function expectationName(): string
    {
        return 'toBeScalar';
    }
}
