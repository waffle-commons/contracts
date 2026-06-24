<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Async;

use Waffle\Commons\Contracts\Async\Exception\DeferralBudgetExceededExceptionInterface;
use Waffle\Commons\Contracts\Service\ResettableInterface;

/**
 * Request-scoped runner that collects deferred tasks and flushes them at
 * finish-request time (ASYNC-01).
 *
 * The runner accumulates tasks during the request via {@see self::defer()} under
 * a bounded per-request budget, then a finish-request listener drains them with
 * {@see self::run()} after the response is flushed. As request-scoped state the
 * runner is {@see ResettableInterface}: the kernel clears the pending queue
 * between requests so no deferred work ever bleeds from request N into N+1.
 */
interface TaskRunnerInterface extends ResettableInterface
{
    /**
     * Enqueue a task to run at finish-request time.
     *
     * @throws DeferralBudgetExceededExceptionInterface When the per-request
     *         deferral budget is exhausted — the signal to move the workload to
     *         a real queue/broker.
     */
    public function defer(DeferredTaskInterface $task): void;

    /**
     * Drain and execute every pending task, isolating per-task failures.
     *
     * Each task runs in its own {@see \Fiber}; a failing task is logged and
     * skipped so it cannot abort the remaining tasks. The model is cooperative
     * (no preemptive timeout): tasks are expected to run to completion, bounded by
     * the per-request deferral budget rather than a wall-clock limit. The pending
     * queue is emptied as it drains.
     */
    public function run(): void;

    /**
     * Number of tasks currently queued for this request.
     */
    public function pending(): int;
}
