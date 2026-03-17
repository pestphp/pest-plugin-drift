<?php

declare(strict_types=1);
use Pest\Drift\Analyzer\ClassMethodAnalyzer;
use Pest\Drift\Extractor\PhpDocTagExtractor;
use Pest\Drift\NodeDecorator\DataProviderDecorator;
use Pest\Drift\NodeDecorator\PhpDocTagDecorator;
use Pest\Drift\Parser\NodeFinder\ClassMethodFinder;
use Pest\Drift\Parser\NodeFinder\MissingUseFinder;
use Pest\Drift\Parser\NodeFinder\NameFinder;
use Pest\Drift\Parser\NodeFinder\NonTestMethodFinder;
use Pest\Drift\Parser\NodeFinder\UseFinder;
use Pest\Drift\Rules\AddMissingUse;
use Pest\Drift\Rules\Assertions\AssertionToExpectation;
use Pest\Drift\Rules\Assertions\AssertionToNegativeExpectation;
use Pest\Drift\Rules\AttributeAnnotations\ConvertDataProvider;
use Pest\Drift\Rules\AttributeAnnotations\ConvertDepends;
use Pest\Drift\Rules\AttributeAnnotations\ConvertGroup;
use Pest\Drift\Rules\ConvertMethodCall;
use Pest\Drift\Rules\ConvertNonTestMethod;
use Pest\Drift\Rules\ConvertStaticCall;
use Pest\Drift\Rules\ConvertTestMethod;
use Pest\Drift\Rules\ExtendsToUses;
use Pest\Drift\Rules\RemoveClass;
use Pest\Drift\Rules\RemoveExtendsUse;
use Pest\Drift\Rules\RemoveNamespace;
use Pest\Drift\Rules\RemoveProperties;
use Pest\Drift\Rules\RemoveTraitsUse;
use Pest\Drift\Rules\SetUpBeforeClassToBeforeAll;
use Pest\Drift\Rules\SetUpToBeforeEach;
use Pest\Drift\Rules\TearDownAfterClassToAfterAll;
use Pest\Drift\Rules\TearDownToAfterEach;
use Pest\Drift\Rules\TraitToUses;
use PhpParser\NodeFinder;

$classMethodAnalyzer = new ClassMethodAnalyzer;
$nodeFinder = new NodeFinder;
$phpDocTagExtractor = new PhpDocTagExtractor;

return [
    new PhpDocTagDecorator($phpDocTagExtractor),
    new DataProviderDecorator($nodeFinder, $phpDocTagExtractor, $classMethodAnalyzer),
    new RemoveClass,
    new RemoveNamespace,
    new ExtendsToUses,
    new RemoveExtendsUse,
    new RemoveTraitsUse,
    new ConvertTestMethod($classMethodAnalyzer, [
        new ConvertDataProvider,
        new ConvertDepends,
        new ConvertGroup,
    ]),
    new ConvertNonTestMethod($classMethodAnalyzer),
    new ConvertMethodCall(
        new NonTestMethodFinder(
            new ClassMethodFinder($nodeFinder),
            $classMethodAnalyzer
        )
    ),
    new ConvertStaticCall(
        new NonTestMethodFinder(
            new ClassMethodFinder($nodeFinder),
            $classMethodAnalyzer
        )
    ),
    new SetUpToBeforeEach($classMethodAnalyzer),
    new SetUpBeforeClassToBeforeAll($classMethodAnalyzer),
    new TearDownToAfterEach($classMethodAnalyzer),
    new TearDownAfterClassToAfterAll($classMethodAnalyzer),
    new RemoveProperties,
    new TraitToUses,
    new AddMissingUse(
        new MissingUseFinder(
            new UseFinder($nodeFinder),
            new NameFinder($nodeFinder),
        )
    ),
    new AssertionToExpectation('assertEquals', 'toEqual', 3),
    new AssertionToExpectation('assertInstanceOf', 'toBeInstanceOf', 3),
    new AssertionToExpectation('assertTrue', 'toBeTrue', 2),
    new AssertionToExpectation('assertFalse', 'toBeFalse', 2),
    new AssertionToExpectation('assertIsArray', 'toBeArray', 2),
    new AssertionToExpectation('assertArrayHasKey', 'toHaveKey', 3),
    new AssertionToExpectation('assertIsString', 'toBeString', 2),
    new AssertionToExpectation('assertEmpty', 'toBeEmpty', 2),
    new AssertionToNegativeExpectation('assertNotEmpty', 'toBeEmpty', 2),
    new AssertionToExpectation('assertContains', 'toContain', 3),
    new AssertionToNegativeExpectation('assertNotContains', 'toContain', 3),
    new AssertionToExpectation('assertSame', 'toBe', 3),
    new AssertionToExpectation('assertNull', 'toBeNull', 2),
    new AssertionToNegativeExpectation('assertNotNull', 'toBeNull', 2),
    new AssertionToExpectation('assertStringStartsWith', 'toStartWith', 3),
    new AssertionToExpectation('assertStringEndsWith', 'toEndWith', 3),
    new AssertionToExpectation('assertThat', 'toMatchConstraint', 3),
    new AssertionToExpectation('assertMatchesRegularExpression', 'toMatch', 3),
    new AssertionToExpectation('assertFileExists', 'toBeFile', 2),
    new AssertionToExpectation('assertFileIsReadable', 'toBeReadableFile', 2),
    new AssertionToExpectation('assertFileIsWritable', 'toBeWritableFile', 2),
    new AssertionToExpectation('assertDirectoryExists', 'toBeDirectory', 2),
    new AssertionToExpectation('assertDirectoryIsReadable', 'toBeReadableDirectory', 2),
    new AssertionToExpectation('assertDirectoryIsWritable', 'toBeWritableDirectory', 2),
    new AssertionToExpectation('assertNan', 'toBeNan', 2),
    new AssertionToExpectation('assertJson', 'toBeJson', 2),
    new AssertionToExpectation('assertIsScalar', 'toBeScalar', 2),
    new AssertionToExpectation('assertIsResource', 'toBeResource', 2),
    new AssertionToExpectation('assertIsObject', 'toBeObject', 2),
    new AssertionToExpectation('assertIsNumeric', 'toBeNumeric', 2),
    new AssertionToExpectation('assertIsIterable', 'toBeIterable', 2),
    new AssertionToExpectation('assertIsInt', 'toBeInt', 2),
    new AssertionToExpectation('assertIsFloat', 'toBeFloat', 2),
    new AssertionToExpectation('assertIsCallable', 'toBeCallable', 2),
    new AssertionToExpectation('assertIsBool', 'toBeBool', 2),
    new AssertionToExpectation('assertInfinite', 'toBeInfinite', 2),
    new AssertionToExpectation('assertEqualsWithDelta', 'toEqualWithDelta', 3),
    new AssertionToExpectation('assertEqualsCanonicalizing', 'toEqualCanonicalizing', 3),
    new AssertionToExpectation('assertCount', 'toHaveCount', 3),
    new AssertionToExpectation('assertLessThan', 'toBeLessThan', 3),
    new AssertionToExpectation('assertLessThanOrEqual', 'toBeLessThanOrEqual', 3),
    new AssertionToExpectation('assertGreaterThan', 'toBeGreaterThan', 3),
    new AssertionToExpectation('assertGreaterThanOrEqual', 'toBeGreaterThanOrEqual', 3),
];
