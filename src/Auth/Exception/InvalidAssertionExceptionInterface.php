<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Exception;

/**
 * Base marker for any rejected identity assertion (RFC-021 §4.3): malformed
 * wire format, undecodable payload, missing claims, or a temporal window
 * wider than `Constant::ASSERTION_TTL`. Specific failures narrow it:
 * {@see SignatureVerificationExceptionInterface},
 * {@see ExpiredAssertionExceptionInterface},
 * {@see ClientIpHijackingExceptionInterface}.
 *
 * Concrete implementations default to HTTP 403.
 */
interface InvalidAssertionExceptionInterface extends AuthenticationExceptionInterface {}
