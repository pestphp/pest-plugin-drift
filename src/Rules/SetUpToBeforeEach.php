<?php

declare(strict_types=1);

namespace Pest\Drift\Rules;

/**
 * @internal
 */
final class SetUpToBeforeEach extends AbstractConvertLifecycleMethod
{
    protected function lifecycleMethodName(): string
    {
        return 'setUp';
    }

    protected function newName(): string
    {
        return 'beforeEach';
    }
}
