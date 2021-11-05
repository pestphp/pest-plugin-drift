<?php

declare(strict_types=1);

return [
    new \PestConverter\Rules\RemoveClass(),
    new \PestConverter\Rules\RemoveNamespace(),
    new \PestConverter\Rules\ExtendsToUses(),
    new \PestConverter\Rules\RemoveUse(),
    new \PestConverter\Rules\ConvertTestMethod(),
    new \PestConverter\Rules\SetUpToBeforeEach(),
    new \PestConverter\Rules\TearDownToAfterEach(),
    new \PestConverter\Rules\RemoveProperties(),
    new \PestConverter\Rules\TraitToUses(),
    new \PestConverter\Rules\Assertions\AssertEquals(),
    new \PestConverter\Rules\Assertions\AssertInstanceOf(),
    new \PestConverter\Rules\Assertions\AssertTrue(),
    new \PestConverter\Rules\Assertions\AssertIsArray(),
    new \PestConverter\Rules\Assertions\AssertArrayHasKey(),
    new \PestConverter\Rules\Assertions\AssertIsString(),
    new \PestConverter\Rules\Assertions\AssertEmpty(),
    new \PestConverter\Rules\Assertions\AssertNotEmpty(),
    new \PestConverter\Rules\Assertions\AssertContains(),
    new \PestConverter\Rules\Assertions\AssertNotContains(),
    new \PestConverter\Rules\Assertions\AssertSame(),
    new \PestConverter\Rules\Assertions\AssertNull(),
];
