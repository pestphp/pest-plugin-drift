<?php

declare(strict_types=1);

namespace Pest\Drift\ValueObject\PhpUnit;

final class TagKey
{
    public const TEST = '@test';

    public const DEPENDS = '@depends';

    public const DATA_PROVIDER = '@dataProvider';

    public const GROUP = '@group';
}
