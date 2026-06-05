<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Runtime;

use Closure;

/**
 * Contract for running an external audit script and streaming its output.
 *
 * Abstracts OS-level process execution behind a contract so the console command
 * layer depends only on `waffle-commons/contracts` (never a concrete engine),
 * exactly like {@see \Waffle\Commons\Contracts\Data\Migration\MigrationRunnerInterface}.
 * The concrete adapter lives in the `waffle-commons/runtime` component and is
 * injected by the application's `bin/waffle`.
 *
 * Implementations MUST:
 *  - execute the script WITHOUT a shell (argv array form — no string
 *    interpolation, no injection surface);
 *  - invoke `$onLine` once per complete output line, with `$isError = true` for
 *    stderr lines so callers can mirror the stream's severity;
 *  - never run during an HTTP request — this is an explicit CLI-only path.
 */
interface AuditRunnerInterface
{
    /**
     * Run `$scriptPath` (with `$arguments`) in `$workingDirectory`, streaming each
     * complete output line to `$onLine` as it is produced.
     *
     * @param list<string> $arguments Flags forwarded verbatim to the script (e.g. ['--local', '--silent']).
     * @param Closure(string $line, bool $isError): void $onLine Invoked once per output line.
     *
     * @return int The script's exit code (0 = success / audit passed).
     */
    public function run(string $scriptPath, string $workingDirectory, array $arguments, Closure $onLine): int;
}
