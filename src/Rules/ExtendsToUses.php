<?php

declare(strict_types=1);

namespace Pest\Drift\Rules;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\NodeVisitorAbstract;

/**
 * @internal
 */
final class ExtendsToUses extends NodeVisitorAbstract
{
    private ?Expression $usesStmt = null;

    private const EXCLUDED_TEST_CASE = [
        'PHPUnit\Framework\TestCase',
        'Tests\TestCase',
    ];

    public function beforeTraverse(array $nodes)
    {
        $this->usesStmt = null;

        return parent::beforeTraverse($nodes);
    }

    /**
     * {@inheritDoc}
     */
    public function enterNode(Node $node)
    {
        if (! $node instanceof Class_) {
            return null;
        }
        if (! $node->extends instanceof Name) {
            return null;
        }
        if (! $node->name instanceof \PhpParser\Node\Identifier) {
            return null;
        }

        /** @var Name $resolvedName */
        $resolvedName = $node->extends->getAttribute('resolvedName');

        if (in_array($resolvedName->toString(), self::EXCLUDED_TEST_CASE, true)) {
            return null;
        }

        $resolvedName->setAttributes([]);

        $this->usesStmt = new Expression(
            new FuncCall(
                new Name('uses'),
                [
                    new Arg(new ClassConstFetch($resolvedName, 'class')),
                ]
            )
        );

        return $node;
    }

    public function afterTraverse(array $nodes): ?array
    {
        if ($this->usesStmt instanceof Expression) {
            array_unshift($nodes, $this->usesStmt);
        }

        return $nodes;
    }
}
