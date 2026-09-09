<?php

declare(strict_types=1);

namespace Pest\Drift\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;

/**
 * @internal
 */
final class SelfCallToMethodCall extends AbstractConvertStaticCall
{
    private const CLASS_SCOPE_NAMES = [
        'self',
        'static',
    ];

    protected function apply(StaticCall $staticCall): int|Node|array|null
    {
        if (! $staticCall->class instanceof Name) {
            return null;
        }
        if (! in_array($staticCall->class->toLowerString(), self::CLASS_SCOPE_NAMES, true)) {
            return null;
        }
        if (! $staticCall->name instanceof Identifier) {
            return null;
        }
        if ($this->enclosingClassCount($staticCall) !== 1) {
            return null;
        }

        return new MethodCall(
            new Variable('this'),
            $staticCall->name,
            $staticCall->getArgs(),
            $staticCall->getAttributes()
        );
    }

    private function enclosingClassCount(StaticCall $staticCall): int
    {
        $count = 0;
        $node = $staticCall->getAttribute('parent');

        while ($node instanceof Node) {
            if ($node instanceof Class_) {
                $count++;
            }

            $node = $node->getAttribute('parent');
        }

        return $count;
    }
}
