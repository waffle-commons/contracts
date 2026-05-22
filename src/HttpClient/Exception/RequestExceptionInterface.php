<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\HttpClient\Exception;

use Psr\Http\Client\RequestExceptionInterface as PsrRequestExceptionInterface;

/**
 * Thrown when the request cannot be sent because it is malformed at the protocol
 * level (e.g., invalid URI scheme, unresolvable host, broken HTTP version).
 *
 * Extends both the Waffle marker and PSR-18's request-exception marker so callers
 * using either type-hint will catch it. Carries the offending `RequestInterface`.
 */
interface RequestExceptionInterface extends HttpClientExceptionInterface, PsrRequestExceptionInterface {}
