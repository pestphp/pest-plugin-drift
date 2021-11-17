<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertFileIsWritable extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertFileIsWritable';
    }

    protected function expectationName(): string
    {
        return 'toBeWritableFile';
    }
}
