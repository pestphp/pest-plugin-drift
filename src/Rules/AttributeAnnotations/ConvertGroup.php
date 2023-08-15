<?php

declare(strict_types=1);

namespace Pest\Drift\Rules\AttributeAnnotations;

use Pest\Drift\ValueObject\PhpUnit\AttributeKey;
use Pest\Drift\ValueObject\PhpUnit\TagKey;
use PhpParser\Node\Arg;
use PhpParser\Node\Scalar\String_;

final class ConvertGroup extends AbstractConvertAttributeAnnotation
{
    private const METHOD_CALL_NAME = 'group';

    protected function getArguments(array $phpDocTags, array $attributeGroups): array
    {
        $groups = $attributeGroups[AttributeKey::GROUP] ?? ($phpDocTags[TagKey::GROUP] ?? []);

        return array_map(fn ($groupName): Arg => new Arg(new String_($groupName)), $groups);
    }

    protected function getMethodCallName(): string
    {
        return self::METHOD_CALL_NAME;
    }
}
