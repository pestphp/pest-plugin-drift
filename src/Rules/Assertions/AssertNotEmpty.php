<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

use PestConverter\Rules\AbstractAssertionToExpectation;
use PhpParser\Node\Arg;
use PhpParser\Node\VariadicPlaceholder;

final class AssertNotEmpty extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertNotEmpty';
    }

    /**
     * @inheritDoc
     */
    protected function actual(array $args): Arg|VariadicPlaceholder
    {
        return $args[0];
    }

    protected function expectationName(): string
    {
        return 'toBeEmpty';
    }

    protected function isNegative(): bool
    {
        return true;
    }
}
