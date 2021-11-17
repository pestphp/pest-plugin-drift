<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\VariadicPlaceholder;
use PhpParser\NodeVisitorAbstract;

abstract class AbstractAssertionToExpectation extends NodeVisitorAbstract
{
    /**
     * @inheritDoc
     */
    public function leaveNode(Node $node)
    {
        if (! $node instanceof MethodCall || ! $node->name instanceof Identifier) {
            return null;
        }

        $assertionName = $node->name->name;

        if ($assertionName !== $this->assertionName()) {
            return null;
        }

        $expect = new FuncCall(
            new Name('expect'),
            [
                $this->actual($node->args),
            ]
        );

        if ($this->isNegative()) {
            $expect = new PropertyFetch($expect, 'not');
        }

        return new MethodCall(
            $expect,
            new Identifier($this->expectationName()),
            $this->expected($node->args)
        );
    }

    /**
     * Extract the expected arguments.
     *
     * @param array<Arg|VariadicPlaceholder> $args
     *
     * @return array<Arg|VariadicPlaceholder>
     */
    protected function expected(array $args): array
    {
        if (1 === count($args)) {
            return [];
        }

        unset($args[1]);

        return $args;
    }

    protected function isNegative(): bool
    {
        return false;
    }

    /**
     * Extract the actual argument to test.
     *
     * @param array<Arg|VariadicPlaceholder> $args
     */
    protected function actual(array $args): Arg|VariadicPlaceholder
    {
        return 1 === count($args) ? $args[0] : $args[1];
    }

    abstract protected function expectationName(): string;

    abstract protected function assertionName(): string;
}
