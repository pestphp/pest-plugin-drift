<?php

declare(strict_types=1);

namespace PestConverter\Rules;

/**
 * Replace setUp method with beforeEach call.
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
