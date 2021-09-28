<?php

namespace PestConverter\Tests\Fixtures;

use PestConverter\Tests\Fixtures\Some\Thing;
use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{
    protected $myProperty;

    protected function setUp(): void
    {
        $this->myProperty = [
            'foo',
            'bar',
        ];
    }

    public function test_using_property()
    {
        $test = $this->myProperty;
    }

    public function test_true_is_true()
    {
        new Thing();
        $this->assertTrue(true);
    }

    public function this_is_not_a_test()
    {
        return true;
    }

    public function test_is_true()
    {
        $this->assertTrue(true);
    }

    public function test_equal()
    {
        $this->assertEquals('foo', 'bar');
    }

    public function test_instanceof()
    {
        $thing = new Thing();
        $this->assertInstanceOf(Thing::class, $thing);
    }

    public function test_is_array()
    {
        $this->assertIsArray([]);
    }

    public function test_array_has_key()
    {
        return $this->assertArrayHasKey('foo', ['foo']);
    }

    public function test_is_string()
    {
        return $this->assertIsString('foo');
    }

    public function test_empty()
    {
        return $this->assertEmpty([]);
    }

    public function test_not_empty()
    {
        return $this->assertNotEmpty([]);
    }

    public function test_contains()
    {
        return $this->assertContains(1, []);
    }
}
