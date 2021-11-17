<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertDirectoryIsWritable extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertDirectoryIsWritable';
    }

    protected function expectationName(): string
    {
        return 'toBeWritableDirectory';
    }
}
