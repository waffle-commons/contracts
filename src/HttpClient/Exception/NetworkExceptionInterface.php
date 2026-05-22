<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\HttpClient\Exception;

use Psr\Http\Client\NetworkExceptionInterface as PsrNetworkExceptionInterface;

/**
 * Thrown on transport-layer failure: DNS resolution, TCP/TLS handshake error,
 * connect timeout, read timeout, or remote connection reset.
 *
 * Extends both the Waffle marker and PSR-18's network-exception marker so callers
 * using either type-hint will catch it. Carries the originating `RequestInterface`.
 */
interface NetworkExceptionInterface extends HttpClientExceptionInterface, PsrNetworkExceptionInterface {}
