<?php

declare(strict_types=1);

namespace PestConverter\Rules;

use PestConverter\Parser\NodeFinder\NonTestMethodFinderInterface;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ClassMethod;

/**
 * Replace non test class method with function.
 */
final class ConvertMethodCall extends AbstractConvertMethodCall
{
    private array $classMethodsToConvert = [];

    public function __construct(
        private NonTestMethodFinderInterface $nonTestMethodFinder,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function beforeTraverse(array $nodes): void
    {
        $this->classMethodsToConvert = array_map(static function (ClassMethod $classMethod) {
            return $classMethod->name->toString();
        }, $this->nonTestMethodFinder->find($nodes));
    }

    protected function apply(MethodCall $methodCall): int|Node|array|null
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
}
