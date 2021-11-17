<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertIsFloat extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertIsFloat';
    }

    protected function expectationName(): string
    {
        return 'toBeFloat';
    }
}
