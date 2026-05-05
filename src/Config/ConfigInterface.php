<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Config;

interface ConfigInterface
{
    public function getInt(string $key, ?int $default = null): ?int;

    public function getString(string $key, ?string $default = null): ?string;

    public function getArray(string $key, ?array $default = null): ?array;

    public function getBool(string $key, ?bool $default = null): ?bool;
}
