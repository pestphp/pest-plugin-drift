<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertIsArray extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertIsArray';
    }

    protected function expectationName(): string
    {
        return 'toBeArray';
    }
}
