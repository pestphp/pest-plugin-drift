<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertIsString extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertIsString';
    }

    protected function expectationName(): string
    {
        return 'toBeString';
    }
}
