<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Console;

/**
 * Contract for a single Console command (RFC-012).
 *
 * Implementations MUST be stateless across invocations (FrankenPHP worker rule)
 * and receive their dependencies through the constructor — never via a static
 * Container accessor.
 */
interface CommandInterface
{
    /**
     * Canonical command name including namespace, e.g. "cache:clear",
     * "route:list", "security:audit".
     */
    public function getName(): string;

    /**
     * Short one-line description shown in `list` output.
     */
    public function getDescription(): string;

    /**
     * Multi-line help block printed by the `help <command>` command.
     * May be empty when the description is self-explanatory.
     */
    public function getHelp(): string;

    /**
     * Single-line usage hint, e.g. "cache:clear [--force] [<environment>]".
     */
    public function getSynopsis(): string;

    /**
     * Executes the command. Implementations MUST return a process exit code:
     * `0` for success, non-zero for failure. The `ExitCode` enum carries
     * named values for common cases.
     */
    public function execute(InputInterface $input, OutputInterface $output): int;
}
