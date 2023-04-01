<?php

declare(strict_types=1);

$classMethodAnalyzer = new \Pest\Pestify\Analyzer\ClassMethodAnalyzer();
$nodeFinder = new \PhpParser\NodeFinder();

return [
    new \Pest\Pestify\Rules\RemoveClass(),
    new \Pest\Pestify\Rules\RemoveNamespace(),
    new \Pest\Pestify\Rules\ExtendsToUses(),
    new \Pest\Pestify\Rules\RemoveExtendsUse(),
    new \Pest\Pestify\Rules\RemoveTraitsUse(),
    new \Pest\Pestify\Rules\ConvertTestMethod($classMethodAnalyzer),
    new \Pest\Pestify\Rules\ConvertNonTestMethod($classMethodAnalyzer),
    new \Pest\Pestify\Rules\ConvertMethodCall(
        new \Pest\Pestify\Parser\NodeFinder\NonTestMethodFinder(
            new \Pest\Pestify\Parser\NodeFinder\ClassMethodFinder($nodeFinder),
            $classMethodAnalyzer
        )
    ),
    new \Pest\Pestify\Rules\SetUpToBeforeEach($classMethodAnalyzer),
    new \Pest\Pestify\Rules\SetUpBeforeClassToBeforeAll($classMethodAnalyzer),
    new \Pest\Pestify\Rules\TearDownToAfterEach($classMethodAnalyzer),
    new \Pest\Pestify\Rules\TearDownAfterClassToAfterAll($classMethodAnalyzer),
    new \Pest\Pestify\Rules\RemoveProperties(),
    new \Pest\Pestify\Rules\TraitToUses(),
    new \Pest\Pestify\Rules\AddMissingUse(
        new \Pest\Pestify\Parser\NodeFinder\MissingUseFinder(
            new \Pest\Pestify\Parser\NodeFinder\UseFinder($nodeFinder),
            new \Pest\Pestify\Parser\NodeFinder\NameFinder($nodeFinder),
        )
    ),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertEquals', 'toEqual'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertInstanceOf', 'toBeInstanceOf'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertTrue', 'toBeTrue'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertFalse', 'toBeFalse'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertIsArray', 'toBeArray'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertArrayHasKey', 'toHaveKey'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertIsString', 'toBeString'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertEmpty', 'toBeEmpty'),
    new \Pest\Pestify\Rules\Assertions\AssertionToNegativeExpectation('assertNotEmpty', 'toBeEmpty'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertContains', 'toContain'),
    new \Pest\Pestify\Rules\Assertions\AssertionToNegativeExpectation('assertNotContains', 'toContain'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertSame', 'toBe'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertNull', 'toBeNull'),
    new \Pest\Pestify\Rules\Assertions\AssertionToNegativeExpectation('assertNotNull', 'toBeNull'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertStringStartsWith', 'toStartWith'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertStringEndsWith', 'toEndWith'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertThat', 'toMatchConstraint'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertMatchesRegularExpression', 'toMatch'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertFileExists', 'toBeFile'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertFileIsReadable', 'toBeReadableFile'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertFileIsWritable', 'toBeWritableFile'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertDirectoryExists', 'toBeDirectory'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertDirectoryIsReadable', 'toBeReadableDirectory'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertDirectoryIsWritable', 'toBeWritableDirectory'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertNan', 'toBeNan'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertJson', 'toBeJson'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertIsScalar', 'toBeScalar'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertIsResource', 'toBeResource'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertIsObject', 'toBeObject'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertIsNumeric', 'toBeNumeric'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertIsIterable', 'toBeIterable'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertIsInt', 'toBeInt'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertIsFloat', 'toBeFloat'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertIsCallable', 'toBeCallable'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertIsBool', 'toBeBool'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertInfinite', 'toBeInfinite'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertEqualsWithDelta', 'toEqualWithDelta'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertEqualsCanonicalizing', 'toEqualCanonicalizing'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertCount', 'toHaveCount'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertLessThan', 'toBeLessThan'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertLessThanOrEqual', 'toBeLessThanOrEqual'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertGreaterThan', 'toBeGreaterThan'),
    new \Pest\Pestify\Rules\Assertions\AssertionToExpectation('assertGreaterThanOrEqual', 'toBeGreaterThanOrEqual'),
];
