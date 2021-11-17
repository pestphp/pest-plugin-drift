<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertLessThanOrEqual extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertLessThanOrEqual';
    }

    protected function expectationName(): string
    {
        return 'toBeLessThanOrEqual';
    }
}
