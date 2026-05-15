<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Console;

use Waffle\Commons\Contracts\Console\Enum\Verbosity;

/**
 * Stdout/Stderr abstraction with per-message verbosity gating (RFC-012 §4).
 *
 * Implementations MUST:
 *  - Route `write()` / `writeLine()` to STDOUT (or an equivalent injected stream).
 *  - Route `writeError()` unconditionally to STDERR — error messages MUST NOT be
 *    silenced by verbosity, since they signal failures that CI/CD pipelines
 *    branch on.
 *  - Honor `$threshold`: emit only when `getVerbosity()->permits($threshold)` is true.
 */
interface OutputInterface
{
    public function write(string $message, Verbosity $threshold = Verbosity::NORMAL): void;

    public function writeLine(string $message, Verbosity $threshold = Verbosity::NORMAL): void;

    /**
     * Writes to stderr regardless of verbosity. Used for failure messages,
     * deprecation warnings, and diagnostic output that CI must surface.
     */
    public function writeError(string $message): void;

    public function getVerbosity(): Verbosity;

    public function setVerbosity(Verbosity $level): void;
}
