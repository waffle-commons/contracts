<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Connection;

use Waffle\Commons\Contracts\Service\ResettableInterface;

/**
 * Per-request ledger of persistent connections opened during a request lifecycle.
 *
 * Implements the DIAG-03 "orphaned connection tracer": connection owners (relational
 * pools, Redis adapters, stream wrappers) report {@see self::trackOpen()} when a handle
 * is opened/borrowed and {@see self::trackClose()} when it is closed/returned to its
 * pool. At the end of the request a listener inspects {@see self::openConnections()};
 * any handle still open is reported as a leak.
 *
 * As a request-scoped ledger this MUST be reset between requests (hence the
 * {@see ResettableInterface} extension): the kernel clears it on `reset()` so no
 * connection id ever bleeds across requests in FrankenPHP resident-worker mode.
 *
 * Implementations are a dev/observability concern and are expected to be wired only
 * in debug environments; production omits the tracker entirely (zero overhead).
 */
interface ConnectionTrackerInterface extends ResettableInterface
{
    /**
     * Record that a connection identified by {@param $id} has been opened/borrowed.
     *
     * Re-reporting the same id is idempotent: the latest open wins.
     */
    public function trackOpen(string $id, ConnectionKind $kind): void;

    /**
     * Record that the connection identified by {@param $id} has been closed/returned.
     *
     * Closing an unknown or already-closed id is a no-op (fail-soft).
     */
    public function trackClose(string $id): void;

    /**
     * Connections still open at the moment of inspection.
     *
     * @return list<array{id: string, kind: ConnectionKind}>
     */
    public function openConnections(): array;
}
