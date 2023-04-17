<?php

declare(strict_types=1);

namespace Pest\Drift\Rules;

/**
 * @internal
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
