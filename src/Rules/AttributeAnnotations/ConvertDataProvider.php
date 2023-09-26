<?php

declare(strict_types=1);

namespace Pest\Drift\Rules\AttributeAnnotations;

use Pest\Drift\ValueObject\PhpUnit\AttributeKey;
use Pest\Drift\ValueObject\PhpUnit\TagKey;
use PhpParser\Node\Arg;
use PhpParser\Node\Scalar\String_;

final class ConvertDataProvider extends AbstractConvertAttributeAnnotation
{
    private const METHOD_CALL_NAME = 'with';

    protected function getArguments(array $phpDocTags, array $attributeGroups): array
    {
        $dataProviders = $attributeGroups[AttributeKey::DATA_PROVIDER] ??
                        $attributeGroups[AttributeKey::DATA_PROVIDER_EXTERNAL] ??
                        $phpDocTags[TagKey::DATA_PROVIDER] ??
                        $phpDocTags[TagKey::DATA_PROVIDER_EXTERNAL] ??
                        [];

        return array_map(fn ($datasetName): Arg => new Arg(new String_($datasetName)), $dataProviders);
    }

    protected function getMethodCallName(): string
    {
        return self::METHOD_CALL_NAME;
    }
}
