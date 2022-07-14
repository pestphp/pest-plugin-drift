<?php

declare(strict_types=1);

namespace PestConverter\Analyzer;

use PhpParser\Comment;
use PhpParser\Node\Stmt\ClassMethod;

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
        ]);
    }

    /**
     * Check if the class method is a test method.
     */
    public function isTestMethod(ClassMethod $classMethod): bool
    {
        $comments = $classMethod->getComments();

        return str_starts_with($classMethod->name->toString(), 'test') || $this->containsTestAnnotation($comments);
    }

    /**
     * Search @test annotations in comments.
     */
    private function containsTestAnnotation(array $comments): bool
    {
        $testAnnotations = array_filter($comments, static function (Comment $comment) {
            return str_contains($comment->getText(), '@test');
        });

        return count($testAnnotations) !== 0;
    }
}
