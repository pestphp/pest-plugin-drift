<?php

declare(strict_types=1);

$classMethodAnalyzer = new \Pest\Drift\Analyzer\ClassMethodAnalyzer();
$nodeFinder = new \PhpParser\NodeFinder();
$phpDocTagExtractor = new \Pest\Drift\Extractor\PhpDocTagExtractor();

return [
    new \Pest\Drift\NodeDecorator\PhpDocTagDecorator($phpDocTagExtractor),
    new \Pest\Drift\NodeDecorator\DataProviderDecorator($nodeFinder, $phpDocTagExtractor),
    new \Pest\Drift\Rules\RemoveClass(),
    new \Pest\Drift\Rules\RemoveNamespace(),
    new \Pest\Drift\Rules\ExtendsToUses(),
    new \Pest\Drift\Rules\RemoveExtendsUse(),
    new \Pest\Drift\Rules\RemoveTraitsUse(),
    new \Pest\Drift\Rules\ConvertTestMethod($classMethodAnalyzer),
    new \Pest\Drift\Rules\ConvertNonTestMethod($classMethodAnalyzer),
    new \Pest\Drift\Rules\ConvertMethodCall(
        new \Pest\Drift\Parser\NodeFinder\NonTestMethodFinder(
            new \Pest\Drift\Parser\NodeFinder\ClassMethodFinder($nodeFinder),
            $classMethodAnalyzer
        )
    ),
    new \Pest\Drift\Rules\SetUpToBeforeEach($classMethodAnalyzer),
    new \Pest\Drift\Rules\SetUpBeforeClassToBeforeAll($classMethodAnalyzer),
    new \Pest\Drift\Rules\TearDownToAfterEach($classMethodAnalyzer),
    new \Pest\Drift\Rules\TearDownAfterClassToAfterAll($classMethodAnalyzer),
    new \Pest\Drift\Rules\RemoveProperties(),
    new \Pest\Drift\Rules\TraitToUses(),
    new \Pest\Drift\Rules\AddMissingUse(
        new \Pest\Drift\Parser\NodeFinder\MissingUseFinder(
            new \Pest\Drift\Parser\NodeFinder\UseFinder($nodeFinder),
            new \Pest\Drift\Parser\NodeFinder\NameFinder($nodeFinder),
        )
    ),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertEquals', 'toEqual'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertInstanceOf', 'toBeInstanceOf'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertTrue', 'toBeTrue'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertFalse', 'toBeFalse'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertIsArray', 'toBeArray'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertArrayHasKey', 'toHaveKey'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertIsString', 'toBeString'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertEmpty', 'toBeEmpty'),
    new \Pest\Drift\Rules\Assertions\AssertionToNegativeExpectation('assertNotEmpty', 'toBeEmpty'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertContains', 'toContain'),
    new \Pest\Drift\Rules\Assertions\AssertionToNegativeExpectation('assertNotContains', 'toContain'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertSame', 'toBe'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertNull', 'toBeNull'),
    new \Pest\Drift\Rules\Assertions\AssertionToNegativeExpectation('assertNotNull', 'toBeNull'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertStringStartsWith', 'toStartWith'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertStringEndsWith', 'toEndWith'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertThat', 'toMatchConstraint'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertMatchesRegularExpression', 'toMatch'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertFileExists', 'toBeFile'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertFileIsReadable', 'toBeReadableFile'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertFileIsWritable', 'toBeWritableFile'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertDirectoryExists', 'toBeDirectory'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertDirectoryIsReadable', 'toBeReadableDirectory'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertDirectoryIsWritable', 'toBeWritableDirectory'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertNan', 'toBeNan'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertJson', 'toBeJson'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertIsScalar', 'toBeScalar'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertIsResource', 'toBeResource'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertIsObject', 'toBeObject'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertIsNumeric', 'toBeNumeric'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertIsIterable', 'toBeIterable'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertIsInt', 'toBeInt'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertIsFloat', 'toBeFloat'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertIsCallable', 'toBeCallable'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertIsBool', 'toBeBool'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertInfinite', 'toBeInfinite'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertEqualsWithDelta', 'toEqualWithDelta'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertEqualsCanonicalizing', 'toEqualCanonicalizing'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertCount', 'toHaveCount'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertLessThan', 'toBeLessThan'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertLessThanOrEqual', 'toBeLessThanOrEqual'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertGreaterThan', 'toBeGreaterThan'),
    new \Pest\Drift\Rules\Assertions\AssertionToExpectation('assertGreaterThanOrEqual', 'toBeGreaterThanOrEqual'),
];
