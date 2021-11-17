<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertIsIterable extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertIsIterable';
    }

    protected function expectationName(): string
    {
        return 'toBeIterable';
    }
}
