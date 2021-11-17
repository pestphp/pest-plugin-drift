<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertLessThan extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertLessThan';
    }

    protected function expectationName(): string
    {
        return 'toBeLessThan';
    }
}
