<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertIsObject extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertIsObject';
    }

    protected function expectationName(): string
    {
        return 'toBeObject';
    }
}
