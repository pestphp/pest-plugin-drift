<?php

declare(strict_types=1);

namespace Pest\Pestify\Rules;

/**
 * Replace setUpBeforeClass method with beforeAll call.
 */
final class SetUpBeforeClassToBeforeAll extends AbstractConvertLifecycleMethod
{
    protected function lifecycleMethodName(): string
    {
        return 'setUpBeforeClass';
    }

    protected function newName(): string
    {
        return 'beforeAll';
    }
}
