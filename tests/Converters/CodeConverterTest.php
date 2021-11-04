<?php

use PestConverter\Converters\CodeConverterFactory;

function codeConverter()
{
    return (new CodeConverterFactory())->codeConverter();
}

it('remove namespace', function () {
    $code = '<?php namespace Test\Namespace;';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->not->toContain('namespace');
});

it('remove class', function () {
    $code = '<?php class MyTest {}';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->not->toContain("class FooTest");
});

it('remove use', function () {
    $code = '<?php
        use PHPUnit\Framework\TestCase;
        use MyClass;
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->not->toContain("use PHPUnit\Framework\TestCase;");
});

it('convert extends class to uses method', function () {
    $code = '<?php
        use PestConverter\Tests\Fixtures\FixtureTestCase;

        class MyTest extends FixtureTestCase {}
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain("uses(\PestConverter\Tests\Fixtures\FixtureTestCase::class);");
});

it('doesnt convert extends PhpUnit TestCase', function () {
    $code = '<?php
        use PHPUnit\Framework\TestCase;

        class MyTest extends TestCase {}
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->not->toContain("uses(\PHPUnit\Framework\TestCase::class);");
    expect($convertedCode)->not->toContain("uses(TestCase::class);");
});

it('convert phpunit class method to pest function call', function () {
    $code = '<?php
        class MyTest {
            public function test_true_is_true() {}
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain("test('true is true', function () {");
});

it('convert lyfecyle method', function () {
    $code = '<?php
        class MyTest {
            protected function setUp() {}
            protected function tearDown() {}
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain("beforeEach");
    expect($convertedCode)->toContain("beforeEach");
    expect($convertedCode)->not->toContain("setUp");
    expect($convertedCode)->not->toContain("tearDown");
});

it('keep non test method', function () {
    $code = '<?php
        class MyTest {
            protected function thisIsNotATest() {}
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain("protected function thisIsNotATest()");
});

it('remove properties', function () {
    $code = '<?php
        class MyTest {
            protected $myProperty;
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->not->toContain('protected $myProperty;');
});

it('keep using traits', function () {
    $code = '<?php
        class MyTest {
            use MyTrait;
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain('uses(\MyTrait::class);');
});

it('convert assertEquals to Pest expectation', function () {
    $code = '<?php
        class MyTest {
            public function test_assert_equals()
            {
                $this->assertEquals("foo", "bar");
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain('expect("bar")->toEqual("foo")');
});

it('convert assertInstanceOf to Pest expectation', function () {
    $code = '<?php
        use PestConverter\Tests\Fixtures\Some\Thing;
        class MyTest {
            public function test_instanceof()
            {
                $this->assertInstanceOf(Thing::class, $thing);
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain('expect($thing)->toBeInstanceOf(\PestConverter\Tests\Fixtures\Some\Thing::class)');
});

it('convert assertTrue to Pest expectation', function () {
    $code = '<?php
        class MyTest {
            public function test_assert_true()
            {
                $this->assertTrue(true);
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain('expect(\true)->toBeTrue()');
});

it('convert assertIsArray to Pest expectation', function () {
    $code = '<?php
        class MyTest {
            public function test_assert_is_array()
            {
                $this->assertIsArray([]);
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain('expect([])->toBeArray()');
});

it('convert assertArrayHasKey to Pest expectation', function () {
    $code = '<?php
        class MyTest {
            public function test_assert_array_has_key()
            {
                $this->assertArrayHasKey("foo", ["foo"]);
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain('expect(["foo"])->toHaveKey("foo")');
});

it('convert assertIsString to Pest expectation', function () {
    $code = '<?php
        class MyTest {
            public function test_assert_is_string()
            {
                $this->assertIsString("foo");
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain('expect("foo")->toBeString()');
});

it('convert assertEmpty to Pest expectation', function () {
    $code = '<?php
        class MyTest {
            public function test_assert_empty()
            {
                $this->assertEmpty([]);
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain("expect([])->toBeEmpty()");
});

it('convert assertNotEmpty to Pest expectation', function () {
    $code = '<?php
        class MyTest {
            public function test_assert_not_empty()
            {
                $this->assertNotEmpty([]);
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain("expect([])->not->toBeEmpty()");
});

it('convert assertContains to Pest expectation', function () {
    $code = '<?php
        class MyTest {
            public function test_assert_contains()
            {
                $this->assertContains(1, []);
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain("expect([])->toContain(1)");
});
