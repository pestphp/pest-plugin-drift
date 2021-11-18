<?php

declare(strict_types=1);

namespace PestConverter\Rules\Assertions;

use PestConverter\Rules\AbstractConvertMethodCall;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\VariadicPlaceholder;

abstract class AbstractAssertionToExpectation extends AbstractConvertMethodCall
{
    public function __construct(
        protected string $oldName,
        protected string $newName,
    ) {
    }

    protected function apply(MethodCall $methodCall): int|Node|array|null
    {
        if (! $methodCall->name instanceof Identifier) {
            return null;
        }

        $assertionName = $methodCall->name->name;

        if ($assertionName !== $this->oldName) {
            return null;
        }

        return new MethodCall(
            $this->buildExpect($methodCall),
            new Identifier($this->newName),
            $this->expected($methodCall->args)
        );
    }

    protected function buildExpect(MethodCall $methodCall): Expr
    {
        return new FuncCall(
            new Name('expect'),
            [
                $this->actual($methodCall->args),
            ]
        );
    }

    /**
     * Extract the expected arguments.
     *
     * @param array<Arg|VariadicPlaceholder> $args
     *
     * @return array<Arg|VariadicPlaceholder>
     */
    private function expected(array $args): array
    {
        if (count($args) === 1) {
            return [];
        }

        unset($args[1]);

        return $args;
    }

    /**
     * Extract the actual argument to test.
     *
     * @param array<Arg|VariadicPlaceholder> $args
     */
    private function actual(array $args): Arg|VariadicPlaceholder
    {
        return count($args) === 1 ? $args[0] : $args[1];
    }
}
