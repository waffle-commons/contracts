<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Assertion;

use Waffle\Commons\Contracts\Auth\Exception\ClientIpHijackingExceptionInterface;
use Waffle\Commons\Contracts\Auth\Exception\ExpiredAssertionExceptionInterface;
use Waffle\Commons\Contracts\Auth\Exception\InvalidAssertionExceptionInterface;
use Waffle\Commons\Contracts\Auth\Exception\SignatureVerificationExceptionInterface;

/**
 * Verifies received identity assertions of the Gateway Assertion Protocol
 * (RFC-021 §4.3).
 *
 * Validation order (every failure throws — never an anonymous downgrade):
 *  1. structural split of `base64url(payload).hex(mac)`;
 *  2. MAC recomputation and comparison via `hash_equals()` ONLY;
 *  3. temporal window: `exp` must be in the future, `iat` must not be in
 *     the future, and `exp − iat` must not exceed
 *     `Constant::ASSERTION_TTL` (anti-replay, anti-window-widening);
 *  4. IP-binding: `hex(HMAC-SHA256(observed client IP, secret))` must equal
 *     the signed `iph` claim (anti-hijacking).
 */
interface AssertionVerifierInterface
{
    /**
     * Verifies a received assertion and returns the asserted claims.
     *
     * @param string $headerValue      The raw `X-Wfl-Assert-User` value.
     * @param string $expectedClientIp The client IP observed by THIS peer,
     *                                 asserted against the signed `iph`.
     *
     * @throws SignatureVerificationExceptionInterface MAC mismatch (HTTP 403).
     * @throws ExpiredAssertionExceptionInterface      Temporal violation (HTTP 403).
     * @throws ClientIpHijackingExceptionInterface     IP-binding failure (HTTP 403).
     * @throws InvalidAssertionExceptionInterface      Structural failure (HTTP 403).
     */
    public function verify(
        #[\SensitiveParameter]
        string $headerValue,
        string $expectedClientIp,
    ): UserAssertionInterface;
}
