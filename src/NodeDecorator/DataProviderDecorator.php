<?php

declare(strict_types=1);

namespace Pest\Drift\NodeDecorator;

use Pest\Drift\Extractor\PhpDocTagExtractor;
use Pest\Drift\ValueObject\Node\AttributeKey;
use Pest\Drift\ValueObject\PhpDoc\TagKey;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeFinder;
use PhpParser\NodeVisitorAbstract;

final class DataProviderDecorator extends NodeVisitorAbstract
{
    /**
     * @var string[]
     */
    private array $dataProviders = [];

    public function __construct(private readonly NodeFinder $nodeFinder, private readonly PhpDocTagExtractor $phpDocTagExtractor)
    {
    }

    public function beforeTraverse(array $nodes)
    {
        /** @var array<int, ClassMethod>  $classMethods */
        $classMethods = $this->nodeFinder->findInstanceOf($nodes, ClassMethod::class);

        foreach ($classMethods as $classMethod) {
            $phpDocTags = $this->phpDocTagExtractor->fromComments($classMethod->getComments());
            $dataProviders = $phpDocTags[TagKey::DATA_PROVIDER] ?? [];
            $this->dataProviders = [...$this->dataProviders, ...$dataProviders];
        }

        return parent::beforeTraverse($nodes);
    }

    public function enterNode(Node $node)
    {
        if (! $node instanceof ClassMethod) {
            return null;
        }

        $node->setAttribute(AttributeKey::IS_DATA_PROVIDER, in_array($node->name->toString(), $this->dataProviders, true));
    }
}
