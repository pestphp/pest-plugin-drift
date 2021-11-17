<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertCount extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertCount';
    }

    protected function expectationName(): string
    {
        return 'toHaveCount';
    }
}
