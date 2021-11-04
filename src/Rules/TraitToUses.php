<?php

declare(strict_types=1);

namespace PestConverter\Rules;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\TraitUse;
use PhpParser\NodeVisitorAbstract;

/**
 * Replace extends with uses pest fonction.
 */
final class TraitToUses extends NodeVisitorAbstract
{
    /**
     * @inheritDoc
     */
    public function leaveNode(Node $node)
    {
        if (! $node instanceof TraitUse) {
            return null;
        }

        $traits = array_map(function ($trait) {
            return new Expression(
                new FuncCall(
                    new Name('uses'),
                    [
                        new Arg(new ClassConstFetch($trait, 'class')),
                    ]
                )
            );
        }, $node->traits);

        return $traits;
    }
}
