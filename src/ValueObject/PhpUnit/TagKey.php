<?php

declare(strict_types=1);

namespace Pest\Drift\ValueObject\PhpUnit;

final class TagKey
{
    public const TEST = '@test';

    public const DEPENDS = '@depends';

    public const DATA_PROVIDER = '@dataProvider';

    public const DATA_PROVIDER_EXTERNAL = '@dataProviderExternal';

    public const GROUP = '@group';
}
