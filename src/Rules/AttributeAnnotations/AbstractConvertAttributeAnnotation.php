<?php

declare(strict_types=1);

namespace Pest\Drift\Rules\AttributeAnnotations;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;

abstract class AbstractConvertAttributeAnnotation
{
    /**
     * @param  array<string, array<int, string>>  $phpDocTags
     * @param  array<string, array<int, string>>  $attributeGroups
     */
    public function apply(Node\Expr\CallLike $testCall, array $phpDocTags, array $attributeGroups): Node\Expr\CallLike
    {
        $arguments = $this->getArguments($phpDocTags, $attributeGroups);

        if ($arguments !== []) {
            return new MethodCall(
                $testCall,
                $this->getMethodCallName(),
                $arguments
            );
        }

        return $testCall;
    }

    /**
     * @param  array<string, array<int, string>>  $phpDocTags
     * @param  array<string, array<int, string>>  $attributeGroups
     * @return array<Node\Arg|Node\VariadicPlaceholder>
     */
    abstract protected function getArguments(array $phpDocTags, array $attributeGroups): array;

    abstract protected function getMethodCallName(): string;
}
