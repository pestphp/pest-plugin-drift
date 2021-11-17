<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

final class AssertEqualsWithDelta extends AbstractAssertionToExpectation
{
    protected function assertionName(): string
    {
        return 'assertEqualsWithDelta';
    }

    /**
     * @inheritDoc
     */
    protected function expected(array $args): array
    {
        return [
            $args[0],
            $args[2],
        ];
    }

    protected function expectationName(): string
    {
        return 'toEqualWithDelta';
    }
}
