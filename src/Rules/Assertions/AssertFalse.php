<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertFalse extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertFalse';
    }

    protected function expectationName(): string
    {
        return 'toBeFalse';
    }
}
