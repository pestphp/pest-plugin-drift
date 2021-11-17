<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertInstanceOf extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertInstanceOf';
    }

    protected function expectationName(): string
    {
        return 'toBeInstanceOf';
    }
}
