<?php

declare(strict_types=1);

namespace Pest\Pestify\Rules;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;

/**
 * Replace test class method with it or test function call.
 */
final class ConvertTestMethod extends AbstractConvertClassMethod
{
    protected function apply(ClassMethod $classMethod): int|Node|array|null
    {
        $methodName = $classMethod->name->toString();
        $attributes = $classMethod->getAttributes();
        $dependsArgument = [];

        if ($classMethod->hasAttribute('comments')) {
            $dependsArgument = $this->extractDependsArgument($attributes['comments']);
            $attributes['comments'] = $this->cleanComments($attributes['comments']);
        }

        // Build test function.
        $testCall = new FuncCall(
            new Name($this->guessFunctionCall($methodName)),
            [
                new Arg(new String_($this->methodNameToDescription($methodName))),
                new Arg(new Closure([
                    'stmts' => $classMethod->stmts,
                    'params' => $classMethod->getParams(),
                ])),
            ]
        );

        if ($dependsArgument !== []) {
            $testCall = new MethodCall(
                $testCall,
                'depends',
                $dependsArgument
            );
        }

        return new Expression($testCall, $attributes);
    }

    /**
     * Filter class methods to convert.
     */
    protected function filter(ClassMethod $classMethod): bool
    {
        return $this->classMethodAnalyzer->isTestMethod($classMethod);
    }

    /**
     * Remove unnecessary annotations and clean empty comments
     */
    private function cleanComments(array $comments): array
    {
        // Remove unnecessary comments.
        $comments = array_map(static function (Comment $comment): Comment {
            $text = $comment->getText();
            $text = preg_replace('/\*[^\*]*(@test)[^\*]*/m', '', $text);
            $text = preg_replace('/\*[^\*]*(@depends)[^\*]*/m', '', $text);

            return new Comment($text, $comment->getStartLine(), $comment->getStartFilePos(), $comment->getStartTokenPos(), $comment->getEndLine(), $comment->getEndFilePos(), $comment->getEndTokenPos());
        }, $comments);

        // Remove empty comments
        $comments = array_filter($comments, static fn (Comment $comment): bool => preg_match('|^/\*[\s\*]*\*+/$|', $comment->getText()) == 0);

        return $comments;
    }

    /**
     * Search @depends annotations in comments and build depends argument with them.
     */
    private function extractDependsArgument(array $comments): array
    {
        $dependsArgument = [];

        $dependAnnotations = array_filter($comments, static fn (Comment $comment): bool => str_contains($comment->getText(), '@depends'));

        foreach ($dependAnnotations as $dependAnnotation) {
            preg_match_all('/@depends ([^ ]*) *$/m', (string) $dependAnnotation->getText(), $matches);

            $dependsArgument = array_map(fn ($testName): \PhpParser\Node\Arg => new Arg(new String_($this->methodNameToDescription($testName))), $matches[1]);
        }

        return $dependsArgument;
    }

    /**
     * Extract Pest description from method name.
     */
    private function methodNameToDescription(string $name): string
    {
        $newName = preg_replace(
            ['/^(test|it)/', '/_/', '/(?=[A-Z])/'],
            ['', ' ', ' '],
            $name
        );

        return trim(strtolower($newName));
    }

    /**
     * Guess if the test function call must be 'test' or 'it'.
     */
    private function guessFunctionCall(string $methodName): string
    {
        if (str_starts_with($methodName, 'it')) {
            return 'it';
        }

        return 'test';
    }
}
