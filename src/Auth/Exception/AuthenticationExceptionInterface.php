<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Exception;

/**
 * Marker for invalid inbound credentials (RFC-021 §3.2): a scheme supported
 * the request but rejected what it carried. Fail-closed — the bridge never
 * downgrades this into an anonymous request.
 *
 * Concrete implementations default to HTTP 401.
 */
interface AuthenticationExceptionInterface extends AuthExceptionInterface {}
