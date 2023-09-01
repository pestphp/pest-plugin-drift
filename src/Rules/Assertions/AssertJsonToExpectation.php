<?php

namespace Pest\Drift\Rules\Assertions;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Name;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Expr\MethodCall;

class AssertJsonToExpectation extends AbstractAssertionToExpectation
{
    protected bool $isPhpUnitAssertJsonCall;

    public function __construct()
    {
        parent::__construct('assertJson', 'assertJson|toBeJson', 2);
    }

    protected function buildExpect(MethodCall $methodCall): Expr
    {
        $this->setIsPhpUnitAssertJsonCall($methodCall->var->name == 'this');

        $this->setNewName();

        return new FuncCall(
            new Name('expect'),
            [
                $this->actual(
                    $this->getArgumentsBasedOnAssertJsonType($methodCall)
                ),
            ]
        );
    }

    protected function expected(array $args): array
    {
        return $this->isPhpUnitAssertJsonCall ? parent::expected($args) : $args;
    }

    private function getArgumentsBasedOnAssertJsonType(MethodCall $methodCall): array
    {
        return $this->isPhpUnitAssertJsonCall
            ? $methodCall->args
            : [new Arg(new Variable($methodCall->var->name))];
    }

    private function setIsPhpUnitAssertJsonCall(bool $isPhpUnitAssertJsonCall): void
    {
        $this->isPhpUnitAssertJsonCall = $isPhpUnitAssertJsonCall;
    }

    private function setNewName(): void
    {
        $this->newName = $this->isPhpUnitAssertJsonCall ? 'toBeJson' : 'assertJson';
    }
}