<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Console;

/**
 * Parsed command invocation surface.
 *
 * `InputInterface` is the read-only view a `CommandInterface::execute()` body uses
 * to inspect arguments (positional, named) and options (flags, key=value) supplied
 * by the user on the command line.
 *
 * Implementations are expected to be immutable once constructed; the framework
 * passes a fresh `InputInterface` per command invocation.
 */
interface InputInterface
{
    /**
     * Returns the value of a named argument, or $default if absent.
     *
     * Arguments are positional values typed without a leading `-`/`--` (e.g.
     * `cache:clear production` — "production" is an argument bound by parsing
     * to the command's declared argument name).
     */
    public function getArgument(string $name, ?string $default = null): ?string;

    /**
     * Returns the value of an option, or $default if absent.
     *
     * Options are typed with a leading `--` (long form) or `-` (short form):
     * `--force`, `--env=prod`, `-v`.
     */
    public function getOption(string $name, ?string $default = null): ?string;

    /**
     * Returns true when the option was supplied on the command line, even if
     * its value is empty. Distinguishes between `--foo=` and "not provided".
     */
    public function hasOption(string $name): bool;

    /**
     * @return array<string, string>
     */
    public function getArguments(): array;

    /**
     * Option values are typically strings, except for boolean flags which
     * return `true` for presence.
     *
     * @return array<string, string|bool>
     */
    public function getOptions(): array;

    /**
     * Raw, unparsed argv (excluding the command name itself) — useful when
     * a command needs to forward args verbatim to a subprocess.
     *
     * @return list<string>
     */
    public function getRawArguments(): array;
}
