<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Exception;

use Waffle\Commons\Contracts\Exception\WaffleExceptionInterface;

/**
 * Marker for any failure raised by the Universal Authentication Bridge
 * (RFC-021).
 *
 * Concrete implementations carry an HTTP status as their exception code
 * (401 for credential failures, 403 for assertion/IP denials, 500 for
 * fail-closed boot) so the error-handler's `getCode()` heuristic renders
 * them without bridge-specific wiring.
 */
interface AuthExceptionInterface extends WaffleExceptionInterface {}
