<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\CircuitBreaker;

use Waffle\Commons\Contracts\RateLimit\Exception\StateStorageExceptionInterface;

/**
 * The shared state of circuit breakers ([NET-03], RFC-024 §3.2, §5.1), in the same storage family as the
 * rate limiter's: every worker sees the same circuit, and each operation is atomic (in Redis, one Lua
 * script), so concurrent workers agree on transitions. The Redis implementation lives in `data`.
 */
interface CircuitStateStorageInterface
{
    /**
     * Asks whether a call through `$circuit` may go now: always when closed, never while open before the
     * cool-down, and for at most `$policy->halfOpenTrials` trial calls when half-open. An open circuit whose
     * cool-down elapsed becomes half-open here.
     *
     * @throws StateStorageExceptionInterface When the storage is unreachable.
     */
    public function acquire(string $circuit, CircuitBreakerPolicy $policy): CircuitDecision;

    /**
     * Records the outcome of a call that went through `$circuit`, opening or closing the circuit as the
     * policy says.
     *
     * @throws StateStorageExceptionInterface When the storage is unreachable.
     */
    public function record(string $circuit, CircuitBreakerPolicy $policy, bool $success): CircuitDecision;
}
