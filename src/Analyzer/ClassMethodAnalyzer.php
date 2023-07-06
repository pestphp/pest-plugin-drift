<?php

declare(strict_types=1);

namespace Pest\Drift\Analyzer;

use Pest\Drift\ValueObject\Node\AttributeKey;
use Pest\Drift\ValueObject\PhpDoc\TagKey;
use PhpParser\Node\Stmt\ClassMethod;

/**
 * @internal
 */
final class ClassMethodAnalyzer implements ClassMethodAnalyzerInterface
{
    /**
     * Check if the class method is a lifecycle method.
     */
    public function isLifecycleMethod(ClassMethod $classMethod): bool
    {
        return in_array($classMethod->name->toString(), [
            'setUp',
            'setUpBeforeClass',
            'tearDown',
            'tearDownAfterClass',
        ], true);
    }

    /**
     * Check if the class method is a test method.
     */
    public function isTestMethod(ClassMethod $classMethod): bool
    {
        return str_starts_with($classMethod->name->toString(), 'test') || $this->containsTestAnnotation($classMethod);
    }

    /**
     * Search @test annotations in comments.
     */
    private function containsTestAnnotation(ClassMethod $classMethod): bool
    {
        /** @var array<string, array<int, string>> $phpDocTags */
        $phpDocTags = $classMethod->getAttribute(AttributeKey::PHP_DOC_TAGS, []);

        return array_key_exists(TagKey::TEST, $phpDocTags);
    }
}
