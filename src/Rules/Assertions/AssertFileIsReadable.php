<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertFileIsReadable extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertFileIsReadable';
    }

    protected function expectationName(): string
    {
        return 'toBeReadableFile';
    }
}
