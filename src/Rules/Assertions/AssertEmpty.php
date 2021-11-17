<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertEmpty extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertEmpty';
    }

    protected function expectationName(): string
    {
        return 'toBeEmpty';
    }
}
