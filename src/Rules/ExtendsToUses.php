<?php

declare(strict_types=1);

namespace PestConverter\Rules;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\NodeVisitorAbstract;

/**
 * Replace extends with uses pest fonction.
 */
final class ExtendsToUses extends NodeVisitorAbstract
{
    private array $excludedTestCase = [
        'PHPUnit\Framework\TestCase',
        'Tests\TestCase',
    ];

    /**
     * @inheritDoc
     */
    public function enterNode(Node $node)
    {
        if (! $node instanceof Class_ || $node->extends === null || in_array($node->extends->getAttribute('resolvedName')->toString(), $this->excludedTestCase)) {
            return null;
        }

        $resolvedName = $node->extends->getAttribute('resolvedName');
        $resolvedName->setAttributes([]);

        $usesStmt = new Expression(
            new FuncCall(
                new Name('uses'),
                [
                    new Arg(new ClassConstFetch($resolvedName, 'class')),
                ]
            )
        );

        array_unshift($node->stmts, $usesStmt);

        return $node;
    }
}
