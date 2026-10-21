<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Migration;

use Closure;

/**
 * Contract for the lightweight SQL migration runner (RFC-022, [OPS-03]).
 *
 * A runner discovers versioned SQL scripts, applies the ones not yet recorded in
 * the migration log, and records each successful application so a second run is a
 * no-op. A version `V` is the file `V.sql`; its optional down script is `V.down.sql`,
 * which {@see self::rollback()} runs to revert it. Implementations MUST:
 *
 *  - resolve their connection from a
 *    {@see \Waffle\Commons\Contracts\Data\Connection\ConnectionPoolInterface} so
 *    the FrankenPHP worker owns the socket lifecycle;
 *  - apply migrations in a deterministic version order, and revert them in the
 *    reverse order;
 *  - wrap each migration (and each revert) in a transaction and roll it back on
 *    failure (fully atomic on engines with transactional DDL — SQLite, PostgreSQL,
 *    SQL Server);
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

    /**
     * Revert the `$steps` most recent applied versions (highest version first) by
     * running each one's down script and removing it from the migration log.
     *
     * Every targeted version is checked before anything runs: when one has no down
     * script, or no script on disk at all, nothing is reverted and the call throws.
     *
     * @param int $steps How many applied versions to revert; at least 1.
     * @param (Closure(string): void)|null $onReverted Invoked once per version
     *        reverted during THIS call, in execution order.
     *
     * @return list<string> The versions reverted, in execution order; empty when
     *         nothing was applied.
     *
     * @throws \InvalidArgumentException When `$steps` is below 1.
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When a targeted version cannot be reverted, or its down script fails
     *         (after its transaction is rolled back).
     */
    public function rollback(int $steps = 1, ?Closure $onReverted = null): array;

    /**
     * Report every known version — on disk, in the log, or both — in version order.
     *
     * @return list<MigrationState>
     *
     * @throws \Waffle\Commons\Contracts\Data\Exception\DatabaseExceptionInterface
     *         When the migration log cannot be read.
     */
    public function status(): array;
}
