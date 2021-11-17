<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertStringEndsWith extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertStringEndsWith';
    }

    protected function expectationName(): string
    {
        return 'toEndWith';
    }
}
