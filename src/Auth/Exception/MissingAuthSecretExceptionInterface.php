<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Exception;

/**
 * Marker for the fail-closed boot rule (RFC-021 §4.2): a secret-requiring
 * scheme was constructed while `WAFFLE_AUTH_SECRET` was missing, empty, or
 * shorter than `Constant::MIN_SECRET_BYTES` (256 bits). Raised during kernel
 * boot — a misconfigured bridge must never degrade into an unauthenticated
 * bypass.
 *
 * Concrete implementations default to HTTP 500.
 */
interface MissingAuthSecretExceptionInterface extends AuthExceptionInterface {}
