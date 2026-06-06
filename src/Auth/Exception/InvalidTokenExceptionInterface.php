<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Exception;

/**
 * Marker for bearer-token validation failures (RFC-021 §4.4): structural
 * decode errors, `alg: none` or non-allow-listed algorithms, signature
 * mismatch, key resolution failure, or claim violations
 * (`exp`/`nbf`/`iss`/`aud`/`nonce`).
 *
 * Concrete implementations default to HTTP 401.
 */
interface InvalidTokenExceptionInterface extends AuthenticationExceptionInterface {}
