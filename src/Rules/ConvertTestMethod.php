<?php

declare(strict_types=1);

namespace Pest\Drift\Rules;

use Pest\Drift\ValueObject\Node\AttributeKey;
use Pest\Drift\ValueObject\PhpDoc\TagKey;
use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;

/**
 * @internal
 */
final class ConvertTestMethod extends AbstractConvertClassMethod
{
    /**
     * {@inheritDoc}
     */
    protected function apply(ClassMethod $classMethod): int|Node|array|null
    {
        $methodName = $classMethod->name->toString();
        $attributes = $classMethod->getAttributes();
        $comments = $classMethod->getComments();
        /** @var array<string, array<int, string>> $phpDocTags */
        $phpDocTags = $classMethod->getAttribute(AttributeKey::PHP_DOC_TAGS, []);

        if ($comments !== []) {
            $attributes['comments'] = $this->cleanComments($comments);
        }

        // Build test function.
        $testCall = new FuncCall(
            new Name($this->guessFunctionCall($methodName)),
            [
                new Arg(new String_($this->methodNameToDescription($methodName))),
                new Arg(new Closure([
                    'stmts' => $classMethod->stmts,
                    'params' => $classMethod->getParams(),
                ])),
            ]
        );

        $testCall = $this->addDepends($testCall, $phpDocTags);
        $testCall = $this->addDataset($testCall, $phpDocTags);
        $testCall = $this->addGroup($testCall, $phpDocTags);

        return new Expression($testCall, $attributes);
    }

    /**
     * Filter class methods to convert.
     */
    protected function filter(ClassMethod $classMethod): bool
    {
        return $this->classMethodAnalyzer->isTestMethod($classMethod);
    }

    /**
     * Remove unnecessary annotations and clean empty comments
     *
     * @param  array<int, Comment>  $comments
     * @return array<int, Comment>
     */
    private function cleanComments(array $comments): array
    {
        // Remove unnecessary comments.
        $comments = array_map(static function (Comment $comment): Comment {
            $text = $comment->getText();
            $text = (string) preg_replace('/\*[^\*]*(@test)[^\*]*/m', '', $text);
            $text = (string) preg_replace('/\*[^\*]*(@depends)[^\*]*/m', '', $text);
            $text = (string) preg_replace('/\*[^\*]*(@dataProvider)[^\*]*/m', '', $text);
            $text = (string) preg_replace('/\*[^\*]*(@group)[^\*]*/m', '', $text);

            return new Comment($text, $comment->getStartLine(), $comment->getStartFilePos(), $comment->getStartTokenPos(), $comment->getEndLine(), $comment->getEndFilePos(), $comment->getEndTokenPos());
        }, $comments);

        // Remove empty comments
        $comments = array_filter($comments, static fn (Comment $comment): bool => preg_match('|^/\*[\s\*]*\*+/$|', $comment->getText()) == 0);

        return $comments;
    }

    /**
     * @param  array<string, array<int, string>>  $phpDocTags
     */
    private function addDepends(Node\Expr\CallLike $testCall, array $phpDocTags): Node\Expr\CallLike
    {
        $depends = $phpDocTags[TagKey::DEPENDS] ?? [];
        $dependsArgument = array_map(fn ($testName): \PhpParser\Node\Arg => new Arg(new String_($this->methodNameToDescription($testName))), $depends);

        if ($dependsArgument !== []) {
            return new MethodCall(
                $testCall,
                'depends',
                $dependsArgument
            );
        }

        return $testCall;
    }

    /**
     * @param  array<string, array<int, string>>  $phpDocTags
     */
    private function addDataset(Node\Expr\CallLike $testCall, array $phpDocTags): Node\Expr\CallLike
    {
        $dataProviders = $phpDocTags[TagKey::DATA_PROVIDER] ?? [];

        $datasetArgument = array_map(fn ($datasetName): \PhpParser\Node\Arg => new Arg(new String_($datasetName)), $dataProviders);

        if ($datasetArgument !== []) {
            return new MethodCall(
                $testCall,
                'with',
                $datasetArgument
            );
        }

        return $testCall;
    }

    /**
     * @param  array<string, array<int, string>>  $phpDocTags
     */
    private function addGroup(Node\Expr\CallLike $testCall, array $phpDocTags): Node\Expr\CallLike
    {
        $groups = $phpDocTags[TagKey::GROUP] ?? [];

        $groupArgument = array_map(fn ($groupName): \PhpParser\Node\Arg => new Arg(new String_($groupName)), $groups);

        if ($groupArgument !== []) {
            return new MethodCall(
                $testCall,
                'group',
                $groupArgument
            );
        }

        return $testCall;
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

    /**
     * Guess if the test function call must be 'test' or 'it'.
     */
    private function guessFunctionCall(string $methodName): string
    {
        if (str_starts_with($methodName, 'it')) {
            return 'it';
        }

        return 'test';
    }
}
