<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Health;

/**
 * A dependency probe behind the readiness endpoint ([OPS-01], RFC-023 §3.1).
 *
 * Components ship their own probes (the database and Redis pools, the cache, the queue driver); the
 * application registers them and declares the required ones by name under `waffle.health.required`. The
 * probe middleware runs them on every `/readyz` call and times each one itself, so a probe stays cheap:
 * it leases a pooled connection rather than opening one.
 */
interface HealthCheckInterface
{
    /**
     * Stable identifier, used in the detailed report and in `waffle.health.required`: "db.pool", "redis".
     */
    public function name(): string;

    /**
     * Whether a failure of this probe makes the instance not ready.
     */
    public function isCritical(): bool;

    /**
     * Probes the dependency within the probe's own timeout, shorter than the orchestrator's. Never throws:
     * a failure is reported as a down result, never raised.
     */
    public function check(): HealthResult;
}
