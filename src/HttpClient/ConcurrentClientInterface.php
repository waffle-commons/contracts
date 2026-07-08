<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\HttpClient;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Concurrent extension of the PSR-18 client surface (ASYNC-02).
 *
 * Lets a consumer depend on the concurrency capability through a contract instead
 * of the concrete client, keeping the dependency perimeter clean. Implementations
 * resolve a batch of outgoing requests in parallel (one shared multi-handle loop),
 * so N requests complete in roughly the wall-clock of the slowest single request.
 */
interface ConcurrentClientInterface
{
    /**
     * Resolve a batch of requests concurrently, preserving the input keys.
     *
     * @param array<array-key, RequestInterface> $requests
     *
     * @return array<array-key, ResponseInterface>
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface When a transfer fails.
     */
    public function sendRequests(array $requests): array;

    /**
     * Begin a single request without blocking, returning a promise that settles
     * when {@see PromiseInterface::wait()} drives it to completion.
     */
    public function promise(RequestInterface $request): PromiseInterface;
}
