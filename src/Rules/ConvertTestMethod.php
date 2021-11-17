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
use PhpParser\NodeVisitorAbstract;

/**
 * Replace test class method with it function call.
 */
final class ConvertTestMethod extends NodeVisitorAbstract
{
    /**
     * @inheritDoc
     */
    public function leaveNode(Node $node)
    {
        if (! $node instanceof ClassMethod || ! $this->filter($node)) {
            return null;
        }

        $methodName = $node->name->toString();

        $attributes = $node->getAttributes();

        if ($node->hasAttribute('comments')) {
            $attributes['comments'] = array_filter($attributes['comments'], static function (Comment $comment) {
                return $comment->getText() !== '/** @test */';
            });
        }

        $newNode = new Expression(new FuncCall(
            new Name($this->guessFunctionCall($methodName)),
            [
                new Arg(new String_($this->methodNameToDescription($methodName))),
                new Arg(new Closure([
                    'stmts' => $node->stmts,
                ])),
            ]
        ), $attributes);

        return $newNode;
    }

    protected function filter(ClassMethod $classMethod): bool
    {
        return $this->isTestMethod($classMethod);
    }

    private function isTestMethod(ClassMethod $classMethod): bool
    {
        $comments = $classMethod->getComments();

        return str_starts_with($classMethod->name->toString(), 'test') || in_array('/** @test */', $comments);
    }

    private function methodNameToDescription(string $name): string
    {
        $newName = preg_replace(
            ['/^(test|it)/', '/_/', '/(?=[A-Z])/'],
            ['', ' ', ' '],
            $name
        );

        return trim(strtolower($newName));
    }

    private function guessFunctionCall(string $methodName): string
    {
        if (str_starts_with($methodName, 'it')) {
            return 'it';
        }

        return 'test';
    }
}
