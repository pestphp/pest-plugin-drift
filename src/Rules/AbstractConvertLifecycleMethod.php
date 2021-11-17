<?php

declare(strict_types=1);

namespace PestConverter\Rules;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\NodeVisitorAbstract;

/**
 * Check if the node is a lifecycle hook method.
 */
abstract class AbstractConvertLifecycleMethod extends NodeVisitorAbstract
{
    /**
     * @inheritDoc
     */
    public function leaveNode(Node $node)
    {
        if (! $node instanceof ClassMethod || $node->name->name !== $this->lifecycleMethodName()) {
            return null;
        }

        $stmts = array_filter($node->stmts ?? [], function (Stmt $stmt) {
            return ! ($stmt instanceof Expression &&
                $stmt->expr instanceof StaticCall &&
                $stmt->expr->name instanceof Identifier &&
                $stmt->expr->name->toString() === $this->lifecycleMethodName());
        });

        return new Expression(new FuncCall(
            new Name($this->newName()),
            [
                new Arg(new Closure([
                    'stmts' => $stmts,
                ])),
            ]
        ), $node->getAttributes());
    }

    abstract protected function lifecycleMethodName(): string;

    abstract protected function newName(): string;
}
