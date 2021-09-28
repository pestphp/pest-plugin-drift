<?php

declare(strict_types=1);

namespace PestConverter\Tests\Fixtures;

class Bar extends FixtureTestCase
{
    protected function setUp(): void
    {
    }

    public function test_false()
    {
        $this->some_method();
        $this->assertFalse(false);
    }

    protected function tearDown(): void
    {
    }
}
