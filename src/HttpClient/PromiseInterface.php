<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\HttpClient;

use Psr\Http\Message\ResponseInterface;
use Throwable;
use Waffle\Commons\Contracts\HttpClient\Enum\PromiseState;

/**
 * A non-blocking handle to an in-flight HTTP request (ASYNC-02).
 *
 * A promise represents one outgoing request whose response is not yet available.
 * Callers register settle callbacks with {@see self::then()} / {@see self::catch()}
 * and either block for the result with {@see self::wait()} or let a concurrent
 * fan-out (resolving an array of promises together) drive every transfer in
 * parallel — N requests complete in roughly the wall-clock of the slowest one.
 *
 * The callbacks are settle notifications, not a monadic chain: they observe the
 * outcome (for logging, buffering, side effects) and return nothing, keeping the
 * abstraction free of propagated `mixed` result types.
 */
interface PromiseInterface
{
    /**
     * Current settlement state.
     */
    public function state(): PromiseState;

    /**
     * Register a callback invoked with the response once the request fulfils.
     *
     * Registering on an already-fulfilled promise invokes the callback
     * immediately. Returns the same promise for fluent registration.
     *
     * @param callable(ResponseInterface): void $onFulfilled
     */
    public function then(callable $onFulfilled): self;

    /**
     * Register a callback invoked with the failure once the request rejects.
     *
     * Registering on an already-rejected promise invokes the callback
     * immediately. Returns the same promise for fluent registration.
     *
     * @param callable(Throwable): void $onRejected
     */
    public function catch(callable $onRejected): self;

    /**
     * Block until the request settles, then return its response.
     *
     * Drives the underlying transfer to completion if it has not already
     * settled.
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface When the request rejected.
     */
    public function wait(): ResponseInterface;
}
