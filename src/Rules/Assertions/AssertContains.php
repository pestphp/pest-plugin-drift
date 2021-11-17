<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertContains extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertContains';
    }

    protected function expectationName(): string
    {
        return 'toContain';
    }
}
