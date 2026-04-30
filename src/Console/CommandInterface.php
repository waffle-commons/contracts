<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Console;

interface CommandInterface
{
    public function getName(): string;

    public function getDescription(): string;

    public function execute(array $arguments = [], array $options = []): int;
}