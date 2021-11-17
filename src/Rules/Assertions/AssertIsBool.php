<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertIsBool extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertIsBool';
    }

    protected function expectationName(): string
    {
        return 'toBeBool';
    }
}
