<?php

declare(strict_types=1);

namespace Pest\Drift\Rules\AttributeAnnotations;

use Pest\Drift\ValueObject\PhpUnit\AttributeKey;
use Pest\Drift\ValueObject\PhpUnit\TagKey;
use PhpParser\Node\Arg;
use PhpParser\Node\Scalar\String_;

final class ConvertDepends extends AbstractConvertAttributeAnnotation
{
    private const METHOD_CALL_NAME = 'depends';

    protected function getArguments(array $phpDocTags, array $attributeGroups): array
    {
        $depends = $attributeGroups[AttributeKey::DEPENDS] ?? ($phpDocTags[TagKey::DEPENDS] ?? []);

        return array_map(fn ($testName): Arg => new Arg(new String_($this->methodNameToDescription($testName))), $depends);
    }

    protected function getMethodCallName(): string
    {
        return self::METHOD_CALL_NAME;
    }

    /**
     * Extract Pest description from method name.
     */
    private function methodNameToDescription(string $name): string
    {
        $newName = (string) preg_replace(
            ['/^(test|it)/', '/_/', '/(?=[A-Z])/'],
            ['', ' ', ' '],
            $name
        );

        return trim(strtolower($newName));
    }
}
