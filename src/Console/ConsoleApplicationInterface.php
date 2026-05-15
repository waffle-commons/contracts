<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Console;

use Waffle\Commons\Contracts\Console\Exception\CommandNotFoundExceptionInterface;

/**
 * Top-level Console application contract (RFC-012).
 *
 * A `ConsoleApplicationInterface` is the registry of commands and the entry point
 * exposed by the `waffle` binary. Per RFC-012, commands are registered explicitly
 * at bootstrap (no auto-discovery magic) and resolve their dependencies through
 * the Container.
 */
interface ConsoleApplicationInterface
{
    /**
     * Returns the application's display name (e.g. "Waffle"). Used in help/usage
     * output.
     */
    public function getName(): string;

    /** Returns the application's version string (semver). */
    public function getVersion(): string;

    /** Registers a command. The command's `getName()` is used as the lookup key. */
    public function add(CommandInterface $command): void;

    /** True when a command with `$name` is registered. */
    public function has(string $name): bool;

    /**
     * Resolves a command by name.
     *
     * @throws CommandNotFoundExceptionInterface when no command matches.
     */
    public function find(string $name): CommandInterface;

    /**
     * Returns every registered command, keyed by command name.
     *
     * @return array<string, CommandInterface>
     */
    public function all(): array;

    /**
     * Parses argv from the runtime environment, dispatches to the matching
     * command, and returns the resulting exit code. `0` indicates success;
     * any non-zero value is a failure per RFC-012 §4.
     */
    public function run(): int;
}
