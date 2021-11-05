<?php

declare(strict_types=1);

namespace PestConverter\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeFinder;
use PhpParser\NodeVisitorAbstract;

/**
 * Replace non test class method with it function call.
 */
final class ConvertNonTestMethod extends NodeVisitorAbstract
{
    private array $classMethodsToConvert = [];

    /**
     * @inheritDoc
     */
    public function beforeTraverse(array $nodes): void
    {
        $nodeFinder = new NodeFinder();


        $classMethods = $nodeFinder->find($nodes, fn (Node $node) => $node instanceof ClassMethod && $this->filter($node));

        foreach ($classMethods as $classMethod) {
            $this->classMethodsToConvert[] = $classMethod->name->toString();
        }
    }

    /**
     * @inheritDoc
     */
    public function leaveNode(Node $node)
    {
        if ($node instanceof ClassMethod && in_array($node->name->toString(), $this->classMethodsToConvert)) {
            return $this->convertClassMethod($node);
        }

        if ($node instanceof MethodCall) {
            return $this->convertMethodCall($node);
        }
    }

    protected function filter(ClassMethod $classMethod): bool
    {
        return ! $this->isTestMethod($classMethod) && ! $this->isLifecycleMethod($classMethod);
    }

    private function convertClassMethod(ClassMethod $classMethod): Function_
    {
        $newNode = new Function_(
            $classMethod->name,
            [
                'byRef' => $classMethod->byRef,
                'params' => $classMethod->params,
                'returnType' => $classMethod->returnType,
                'stmts' => $classMethod->stmts,
                'attrGroups' => $classMethod->attrGroups,
            ]
        );

        $newNode->setAttribute('original_node', $classMethod);

        return $newNode;
    }

    private function convertMethodCall(MethodCall $methodCall): ?FuncCall
    {
        if (! $methodCall->name instanceof Identifier || ! in_array($methodCall->name->toString(), $this->classMethodsToConvert)) {
            return null;
        }

        return new FuncCall(
            new Name($methodCall->name->toString()),
            $methodCall->getArgs(),
            $methodCall->getAttributes()
        );
    }

    private function isLifecycleMethod(ClassMethod $classMethod): bool
    {
        return in_array($classMethod->name->toString(), [
            'setUp',
            'setUpBeforeClass',
            'tearDown',
            'tearDownAfterClass',
        ]);
    }

    private function isTestMethod(ClassMethod $classMethod): bool
    {
        $comments = $classMethod->getComments();

        return str_starts_with($classMethod->name->toString(), 'test') || in_array('/** @test */', $comments);
    }
}
