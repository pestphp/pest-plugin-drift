<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertEquals extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertEquals';
    }

    protected function expectationName(): string
    {
        return 'toEqual';
    }
}
