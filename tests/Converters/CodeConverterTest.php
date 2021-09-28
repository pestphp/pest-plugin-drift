<?php

use PestConverter\Converters\CodeConverterFactory;

function foo()
{
    return file_get_contents(__DIR__ . '/../fixtures/Converters/FooTest.php');
}

function bar()
{
    return file_get_contents(__DIR__ . '/../fixtures/Converters/BarTest.php');
}

function codeConverter()
{
    return (new CodeConverterFactory())->codeConverter();
}

it('remove namespace', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->not->toContain('namespace');
});

it('remove class', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->not->toContain("class FooTest");
});

// it('keep use', function () {
//     $convertedCode = codeConverter()->convert(foo());

//     expect($convertedCode)->toContain("use PestConverter\Tests\Fixtures\Some\Thing;");
// });

it('remove base TestCase use', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->not->toContain("use PHPUnit\Framework\TestCase;");
});

it('convert extends class to uses method', function () {
    $convertedCode = codeConverter()->convert(bar());

    expect($convertedCode)->toContain("uses(\PestConverter\Tests\Fixtures\FixtureTestCase::class);");
});

it('doesnt convert extends PhpUnit TestCase', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->not->toContain("uses(\PHPUnit\Framework\TestCase::class);");
    expect($convertedCode)->not->toContain("uses(TestCase::class);");
});

it('convert phpunit class method to pest function call', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->toContain("test('true is true', function () {");
});

it('convert lyfecyle method', function () {
    $convertedCode = codeConverter()->convert(bar());

    expect($convertedCode)->toContain("beforeEach");
    expect($convertedCode)->toContain("afterEach");
});

it('keep non test method', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->toContain("function this_is_not_a_test()");
});

it('convert properties to function call', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->not->toContain('protected $myProperty;');
    expect($convertedCode)->toContain('$test = $this->myProperty;');
});

it('convert assertEquals to Pest expectation', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->toContain("expect('bar')->toEqual('foo')");
});

it('convert assertInstanceOf to Pest expectation', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->toContain('expect($thing)->toBeInstanceOf(\PestConverter\Tests\Fixtures\Some\Thing::class)');
});

it('convert assertTrue to Pest expectation', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->toContain('expect(true)->toBeTrue()');
});

it('convert assertIsArray to Pest expectation', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->toContain('expect([])->toBeArray()');
});

it('convert assertArrayHasKey to Pest expectation', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->toContain("expect(['foo'])->toHaveKey('foo')");
});

it('convert assertIsString to Pest expectation', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->toContain("expect('foo')->toBeString()");
});

it('convert assertEmpty to Pest expectation', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->toContain("expect([])->toBeEmpty()");
});

it('convert assertNotEmpty to Pest expectation', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->toContain("expect([])->not->toBeEmpty()");
});

it('convert assertContains to Pest expectation', function () {
    $convertedCode = codeConverter()->convert(foo());

    expect($convertedCode)->toContain("expect([])->toContain(1)");
});
