<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Exception;

/**
 * Marker for an assertion whose HMAC signature does not match its payload
 * under `hash_equals()` (RFC-021 §4.3) — a single mutated character lands
 * here.
 *
 * Concrete implementations default to HTTP 403.
 */
interface SignatureVerificationExceptionInterface extends InvalidAssertionExceptionInterface {}
