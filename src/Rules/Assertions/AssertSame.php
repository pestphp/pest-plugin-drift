<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertSame extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertSame';
    }

    protected function expectationName(): string
    {
        return 'toBe';
    }
}
