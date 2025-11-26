<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Config;

interface ConfigInterface
{
    public function getInt(string $key, null|int $default = null): null|int;

    public function getString(string $key, null|string $default = null): null|string;

    public function getArray(string $key, null|array $default = null): null|array;

    public function getBool(string $key, bool $default = false): bool;
}
