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

it('remove unnecessary use', function () {
    $code = '<?php
        use PHPUnit\Framework\TestCase;
        use My\Class;

        class MyTest extends TestCase {}
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->not->toContain("use PHPUnit\Framework\TestCase;");
    expect($convertedCode)->toContain("use My\Class;");
});

it('convert extends class to uses method', function () {
    $code = '<?php
        use PestConverter\Tests\Fixtures\FixtureTestCase;

        class MyTest extends FixtureTestCase {}
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)
        ->not->toContain('use PestConverter\Tests\Fixtures\FixtureTestCase;')
        ->toContain("uses(\PestConverter\Tests\Fixtures\FixtureTestCase::class);");
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

            public function testFalseIsFalse() {}

            /** @test */
            public function it_works() {}
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)
        ->toContain("test('true is true', function () {")
        ->toContain("test('false is false', function () {")
        ->toContain("it('works', function () {")
        ->not->toContain('/** @test */');
});

it('convert lifecyle method', function () {
    $code = '<?php
        class MyTest {
            protected function setUp() {
                parent::setUp();
            }
            protected function setUpBeforeClass() {
                parent::setUpBeforeClass();
            }
            protected function tearDown() {
                parent::tearDown();
            }
            protected function tearDownAfterClass() {
                parent::tearDownAfterClass();
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain("beforeEach");
    expect($convertedCode)->toContain("beforeAll");
    expect($convertedCode)->toContain("afterEach");
    expect($convertedCode)->toContain("afterAll");
    expect($convertedCode)->not->toContain("setUp");
    expect($convertedCode)->not->toContain("setUpBeforeClass");
    expect($convertedCode)->not->toContain("tearDown");
    expect($convertedCode)->not->toContain("tearDownAfterClass");
});

it('convert non test method', function () {
    $code = '<?php
        class MyTest {
            protected function thisIsNotATest() {}

            public function test_non_test_method()
            {
                $this->thisIsNotATest();
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)
        ->toContain('function thisIsNotATest()')
        ->not->toContain('protected function thisIsNotATest()')
        ->toContain('thisIsNotATest()')
        ->not->toContain('$this->thisIsNotATest()');
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
        use My\CustomTrait;
        class MyTest {
            use CustomTrait;
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)
        ->toContain('uses(\My\CustomTrait::class);')
        ->not->toContain('use My\CustomTrait;')
        ->not->toContain('use CustomTrait;');
});

it('add missing use', function () {
    $code = '<?php
        namespace PestConverter\Tests;

        use PestConverter\Tests\Helper\Foo;

        class MyTest {
            public function test_foo()
            {
                $foo = new Foo();
                $bar = new Bar();
                $date = new DateTime();
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain('use \PestConverter\Tests\Bar;');
});

it('keep multiline statements', function () {
    $code = '<?php
        class MyTest {
            public function multiline_statement()
            {
                $object
                    ->foo()
                    ->bar()
                    ->hello(
                        $the,
                        $world
                    );

                $alpha = "beta";
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    $expected = '
    $object
        ->foo()
        ->bar()
        ->hello(
            $the,
            $world
        );

    $alpha = "beta";';

    expect($convertedCode)->toContain($expected);
});

it('keep breakline between methods', function () {
    $code = '<?php
        class MyTest {
            public function test_method()
            {
            }

            public function first_method()
            {
            }

            public function second_method()
            {
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    $expected = "
test('method', function () {
});

function first_method()
{
}

function second_method()
{
}";

    expect($convertedCode)->toContain($expected);
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

    expect($convertedCode)
        ->toContain('use PestConverter\Tests\Fixtures\Some\Thing;')
        ->toContain('expect($thing)->toBeInstanceOf(Thing::class)');
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

    expect($convertedCode)->toContain('expect(true)->toBeTrue()');
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

it('convert assertNotContains to Pest expectation', function () {
    $code = '<?php
        class MyTest {
            public function test_assert_not_contains()
            {
                $this->assertNotContains(1, []);
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain("expect([])->not->toContain(1)");
});

it('convert assertSame to Pest expectation', function () {
    $code = '<?php
        class MyTest {
            public function test_assert_same()
            {
                $myObject = new Object();

                $this->assertSame($object, $object);
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain('expect($object)->toBe($object)');
});

it('convert assertNull to Pest expectation', function () {
    $code = '<?php
        class MyTest {
            public function test_assert_null()
            {
                $this->assertNull(null);
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain('expect(null)->toBeNull()');
});

it('convert assertNotNull to Pest expectation', function () {
    $code = '<?php
        class MyTest {
            public function test_assert_null()
            {
                $this->assertNotNull(null);
            }
        }
    ';

    $convertedCode = codeConverter()->convert($code);

    expect($convertedCode)->toContain('expect(null)->not->toBeNull()');
});
