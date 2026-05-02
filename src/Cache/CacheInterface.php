<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Cache;

use Psr\SimpleCache\CacheInterface as PsrSimpleCacheInterface;

interface CacheInterface extends PsrSimpleCacheInterface
{
    public function clear(): bool;
}
