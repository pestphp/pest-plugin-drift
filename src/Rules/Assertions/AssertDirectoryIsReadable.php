<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertDirectoryIsReadable extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertDirectoryIsReadable';
    }

    protected function expectationName(): string
    {
        return 'toBeReadableDirectory';
    }
}
