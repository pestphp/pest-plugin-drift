<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertNan extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertNan';
    }

    protected function expectationName(): string
    {
        return 'toBeNan';
    }
}
