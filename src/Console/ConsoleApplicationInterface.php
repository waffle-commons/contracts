<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Console;

interface ConsoleApplicationInterface
{
    public function run(): int;

    public function add(CommandInterface $command): void;
}