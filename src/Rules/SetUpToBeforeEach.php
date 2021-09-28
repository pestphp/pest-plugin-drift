<?php

declare(strict_types=1);

namespace PestConverter\Rules;

/**
 * Replace setUp method with beforeEach call.
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
