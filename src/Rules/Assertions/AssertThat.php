<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertThat extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertThat';
    }

    protected function expectationName(): string
    {
        return 'toMatchConstraint';
    }
}
