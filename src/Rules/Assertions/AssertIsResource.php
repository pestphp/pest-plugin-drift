<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertIsResource extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertIsResource';
    }

    protected function expectationName(): string
    {
        return 'toBeResource';
    }
}
