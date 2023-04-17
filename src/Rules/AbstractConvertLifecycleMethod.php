<?php

declare(strict_types=1);

namespace Pest\Drift\Rules;

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

/**
 * @internal
 */
abstract class AbstractConvertLifecycleMethod extends AbstractConvertClassMethod
{
    protected function apply(ClassMethod $classMethod): int|Node|array|null
    {
        // Remove parent lifecyle call.
        $stmts = array_filter($classMethod->stmts ?? [], fn (Stmt $stmt): bool => ! ($stmt instanceof Expression &&
            $stmt->expr instanceof StaticCall &&
            $stmt->expr->name instanceof Identifier &&
            $stmt->expr->name->toString() === $this->lifecycleMethodName()));

        // Build Pest lifecycle Method.
        return new Expression(new FuncCall(
            new Name($this->newName()),
            [
                new Arg(new Closure([
                    'stmts' => $stmts,
                ])),
            ]
        ), $classMethod->getAttributes());
    }

    protected function filter(ClassMethod $classMethod): bool
    {
        return $classMethod->name->name === $this->lifecycleMethodName();
    }

    /**
     * Get PHPUnit lifecycle method name.
     */
    abstract protected function lifecycleMethodName(): string;

    /**
     * Get Pest lifecycle method name.
     */
    abstract protected function newName(): string;
}
