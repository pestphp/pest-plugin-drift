<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertMatchesRegularExpression extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertMatchesRegularExpression';
    }

    protected function expectationName(): string
    {
        return 'toMatch';
    }
}
