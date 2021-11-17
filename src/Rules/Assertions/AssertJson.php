<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertJson extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertJson';
    }

    protected function expectationName(): string
    {
        return 'toBeJson';
    }
}
