<?php

declare(strict_types=1);

namespace Pest\Drift\Rules;

/**
 * @internal
 */
final class TearDownToAfterEach extends AbstractConvertLifecycleMethod
{
    protected function lifecycleMethodName(): string
    {
        return 'tearDown';
    }

    protected function newName(): string
    {
        return 'afterEach';
    }
}
