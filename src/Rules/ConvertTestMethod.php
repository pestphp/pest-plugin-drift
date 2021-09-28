<?php

declare(strict_types=1);

namespace PestConverter\Rules;

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

        $newNode = new Expression(new FuncCall(
            new Name('test'),
            [
                new Arg(new String_($this->methodNameToDescription($methodName))),
                new Arg(new Closure([
                    'stmts' => $node->stmts,
                ])),
            ]
        ));

        $newNode->setAttribute('original_node', $node);

        return $newNode;
    }

    protected function filter(ClassMethod $classMethod): bool
    {
        return $this->isTestMethod($classMethod);
    }

    private function isTestMethod(ClassMethod $classMethod): bool
    {
        return str_starts_with($classMethod->name->toString(), 'test');
    }

    private function methodNameToDescription(string $name): string
    {
        $newName = preg_replace(
            ['/^test/', '/_/', '/(?=[A-Z])/'],
            ['', ' ', ' '],
            $name
        );

        return trim(strtolower($newName));
    }
}
