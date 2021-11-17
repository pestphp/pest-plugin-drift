<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertEqualsCanonicalizing extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertEqualsCanonicalizing';
    }

    protected function expectationName(): string
    {
        return 'toEqualCanonicalizing';
    }
}
