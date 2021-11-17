<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertStringStartsWith extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertStringStartsWith';
    }

    protected function expectationName(): string
    {
        return 'toStartWith';
    }
}
