<?php

declare(strict_types=1);

$classMethodAnalyzer = new \PestConverter\Analyzer\ClassMethodAnalyzer();
$nodeFinder = new \PhpParser\NodeFinder();

return [
    new \PestConverter\Rules\RemoveClass(),
    new \PestConverter\Rules\RemoveNamespace(),
    new \PestConverter\Rules\ExtendsToUses(),
    new \PestConverter\Rules\RemoveExtendsUse(),
    new \PestConverter\Rules\RemoveTraitsUse(),
    new \PestConverter\Rules\ConvertTestMethod($classMethodAnalyzer),
    new \PestConverter\Rules\ConvertNonTestMethod($classMethodAnalyzer),
    new \PestConverter\Rules\ConvertMethodCall(
        new \PestConverter\Parser\NodeFinder\NonTestMethodFinder(
            new \PestConverter\Parser\NodeFinder\ClassMethodFinder($nodeFinder),
            $classMethodAnalyzer
        )
    ),
    new \PestConverter\Rules\SetUpToBeforeEach($classMethodAnalyzer),
    new \PestConverter\Rules\SetUpBeforeClassToBeforeAll($classMethodAnalyzer),
    new \PestConverter\Rules\TearDownToAfterEach($classMethodAnalyzer),
    new \PestConverter\Rules\TearDownAfterClassToAfterAll($classMethodAnalyzer),
    new \PestConverter\Rules\RemoveProperties(),
    new \PestConverter\Rules\TraitToUses(),
    new \PestConverter\Rules\AddMissingUse(
        new \PestConverter\Parser\NodeFinder\MissingUseFinder(
            new \PestConverter\Parser\NodeFinder\UseFinder($nodeFinder),
            new \PestConverter\Parser\NodeFinder\NameFinder($nodeFinder),
        )
    ),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertEquals', 'toEqual'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertInstanceOf', 'toBeInstanceOf'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertTrue', 'toBeTrue'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertFalse', 'toBeFalse'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertIsArray', 'toBeArray'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertArrayHasKey', 'toHaveKey'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertIsString', 'toBeString'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertEmpty', 'toBeEmpty'),
    new \PestConverter\Rules\Assertions\AssertionToNegativeExpectation('assertNotEmpty', 'toBeEmpty'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertContains', 'toContain'),
    new \PestConverter\Rules\Assertions\AssertionToNegativeExpectation('assertNotContains', 'toContain'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertSame', 'toBe'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertNull', 'toBeNull'),
    new \PestConverter\Rules\Assertions\AssertionToNegativeExpectation('assertNotNull', 'toBeNull'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertStringStartsWith', 'toStartWith'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertStringEndsWith', 'toEndWith'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertThat', 'toMatchConstraint'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertMatchesRegularExpression', 'toMatch'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertFileExists', 'toBeFile'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertFileIsReadable', 'toBeReadableFile'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertFileIsWritable', 'toBeWritableFile'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertDirectoryExists', 'toBeDirectory'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertDirectoryIsReadable', 'toBeReadableDirectory'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertDirectoryIsWritable', 'toBeWritableDirectory'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertNan', 'toBeNan'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertJson', 'toBeJson'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertIsScalar', 'toBeScalar'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertIsResource', 'toBeResource'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertIsObject', 'toBeObject'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertIsNumeric', 'toBeNumeric'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertIsIterable', 'toBeIterable'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertIsInt', 'toBeInt'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertIsFloat', 'toBeFloat'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertIsCallable', 'toBeCallable'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertIsBool', 'toBeBool'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertInfinite', 'toBeInfinite'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertEqualsWithDelta', 'toEqualWithDelta'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertEqualsCanonicalizing', 'toEqualCanonicalizing'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertCount', 'toHaveCount'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertLessThan', 'toBeLessThan'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertLessThanOrEqual', 'toBeLessThanOrEqual'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertGreaterThan', 'toBeGreaterThan'),
    new \PestConverter\Rules\Assertions\AssertionToExpectation('assertGreaterThanOrEqual', 'toBeGreaterThanOrEqual'),
];
