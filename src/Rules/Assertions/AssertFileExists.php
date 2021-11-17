<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertFileExists extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertFileExists';
    }

    protected function expectationName(): string
    {
        return 'toBeFile';
    }
}
