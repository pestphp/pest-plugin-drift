<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertInfinite extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertInfinite';
    }

    protected function expectationName(): string
    {
        return 'toBeInfinite';
    }
}
