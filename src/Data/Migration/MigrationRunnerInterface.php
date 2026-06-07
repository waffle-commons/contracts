<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Migration;

use Closure;

/**
 * Contract for the lightweight, forward-only SQL migration runner (RFC-022).
 *
 * A runner discovers versioned SQL scripts, applies the ones not yet recorded in
 * the migration log, and records each successful application so a second run is a
 * no-op. Implementations MUST:
 *
 *  - resolve their connection from a
 *    {@see \Waffle\Commons\Contracts\Data\Connection\ConnectionPoolInterface} so
 *    the FrankenPHP worker owns the socket lifecycle;
 *  - apply migrations in a deterministic version order;
 *  - wrap each migration in a transaction and roll it back on failure (fully
 *    atomic on engines with transactional DDL — SQLite, PostgreSQL);
 *  - be safe to call repeatedly: already-applied versions are skipped, never
 *    re-executed.
 *
 * Discovery and execution happen only on the explicit CLI path — never during an
 * HTTP request — per the zero-magic registry mandate.
 */
interface MigrationRunnerInterface
{
    /**
     * Apply every pending migration in version order and record each one in the
     * migration log table, creating that table on the first run if absent.
     *
     * @param (Closure(string): void)|null $onApplied Invoked once per migration
     *        applied during THIS call, in execution order, with the version id —
     *        lets a CLI surface progress in real time. Never invoked for skipped
     *        (already-applied) migrations.
     *
     * @return list<string> The versions applied during this call, in execution
     *         order; empty when the database was already up to date.
     *
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When a migration fails to apply (after its transaction is rolled
     *         back) or the migration source cannot be read.
     */
    public function run(?Closure $onApplied = null): array;
}
