<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Exception;

/**
 * Marker for the anti-replay rule (RFC-021 §4.3): the assertion's `iat`
 * exceeds the strict TTL window (`Constant::ASSERTION_TTL`, 5 seconds by
 * default).
 *
 * Concrete implementations default to HTTP 403.
 */
interface ExpiredAssertionExceptionInterface extends InvalidAssertionExceptionInterface {}
