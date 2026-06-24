<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Async;

/**
 * A unit of work deferred to finish-request time (ASYNC-01).
 *
 * Deferred tasks run AFTER the response has been flushed to the client and
 * BEFORE the worker accepts its next request — short post-response work (mail
 * delivery, webhook fan-out, audit log writes) lifted out of the user-perceived
 * latency path. A task MUST be self-contained and bounded; long-running work
 * belongs in a real queue/broker, not the deferral budget.
 */
interface DeferredTaskInterface
{
    /**
     * Execute the deferred work.
     *
     * Runs inside an isolated {@see \Fiber} so a thrown failure is logged and
     * contained, never aborting sibling tasks. The runner is cooperative, not
     * preemptive: a task is expected to run to completion (heavy/long work belongs
     * in a real queue, bounded by the per-request deferral budget — not a timeout).
     *
     * @throws \Throwable When the work fails (caught and isolated by the runner).
     */
    public function run(): void;

    /**
     * Short, stable label used in logs and telemetry for this task.
     */
    public function name(): string;
}
