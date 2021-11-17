<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertDirectoryExists extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertDirectoryExists';
    }

    protected function expectationName(): string
    {
        return 'toBeDirectory';
    }
}
