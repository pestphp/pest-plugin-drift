<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

use PestConverter\Rules\AbstractAssertionToExpectation;
use PhpParser\Node\Arg;
use PhpParser\Node\VariadicPlaceholder;

final class AssertArrayHasKey extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertArrayHasKey';
    }

    /**
     * @inheritDoc
     */
    protected function actual(array $args): Arg|VariadicPlaceholder
    {
        return $args[1];
    }

    /**
     * @inheritDoc
     */
    protected function expected(array $args): array
    {
        return [
            $args[0],
        ];
    }

    protected function expectationName(): string
    {
        return 'toHaveKey';
    }
}
