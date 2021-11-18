<?php

declare(strict_types=1);

namespace PestConverter\Rules;

use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
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

        // Remove unnecessary comments.
        if ($classMethod->hasAttribute('comments')) {
            $attributes['comments'] = array_filter($attributes['comments'], static function (Comment $comment) {
                return $comment->getText() !== '/** @test */';
            });
        }

        // Build test function.
        return new Expression(new FuncCall(
            new Name($this->guessFunctionCall($methodName)),
            [
                new Arg(new String_($this->methodNameToDescription($methodName))),
                new Arg(new Closure([
                    'stmts' => $classMethod->stmts,
                ])),
            ]
        ), $attributes);
    }

    /**
     * Filter class methods to convert.
     */
    protected function filter(ClassMethod $classMethod): bool
    {
        return $this->classMethodAnalyzer->isTestMethod($classMethod);
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
