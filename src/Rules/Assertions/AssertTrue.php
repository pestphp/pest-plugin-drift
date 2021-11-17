<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertTrue extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertTrue';
    }

    protected function expectationName(): string
    {
        return 'toBeTrue';
    }
}
