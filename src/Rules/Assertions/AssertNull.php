<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertNull extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertNull';
    }

    protected function expectationName(): string
    {
        return 'toBeNull';
    }
}
