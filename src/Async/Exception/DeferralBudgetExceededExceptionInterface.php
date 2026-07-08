<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Async\Exception;

/**
 * Raised when a request defers more tasks than its bounded budget allows.
 *
 * This is the explicit "move it to a real queue" signal: finish-request deferral
 * trades worker throughput for perceived latency and is not a substitute for
 * background processing, so the budget is a hard ceiling rather than advisory.
 */
interface DeferralBudgetExceededExceptionInterface extends AsyncExceptionInterface
{
    /**
     * The per-request deferral budget that was exceeded.
     */
    public function budget(): int;
}
