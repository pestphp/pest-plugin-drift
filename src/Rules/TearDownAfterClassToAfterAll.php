<?php

declare(strict_types=1);

namespace PestConverter\Rules;

/**
 * Replace tearDown method with afterEach call.
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
