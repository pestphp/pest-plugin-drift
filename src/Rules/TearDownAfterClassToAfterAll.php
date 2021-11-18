<?php

declare(strict_types=1);

namespace PestConverter\Rules;

/**
 * Replace tearDownAfterClass method with afterAll call.
 */
final class TearDownAfterClassToAfterAll extends AbstractConvertLifecycleMethod
{
    protected function lifecycleMethodName(): string
    {
        return 'tearDownAfterClass';
    }

    protected function newName(): string
    {
        return 'afterAll';
    }
}
