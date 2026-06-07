<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Exception;

/**
 * Marker for the IP-binding rule (RFC-021 §4.3): the keyed hash of the
 * verifying peer's observed client IP differs from the signed `iph` claim —
 * the assertion is being replayed from a different client (hijacking).
 *
 * Concrete implementations default to HTTP 403.
 */
interface ClientIpHijackingExceptionInterface extends InvalidAssertionExceptionInterface {}
