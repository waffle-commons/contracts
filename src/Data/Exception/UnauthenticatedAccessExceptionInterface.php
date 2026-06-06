<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Exception;

/**
 * Raised when a guarded backend operation is attempted without an authenticated
 * identity (RFC-022 §4.2, Firestore Rule 3): every read or write through such a
 * driver MUST be preceded by a successful identity check, never an anonymous
 * fall-through.
 *
 * Extends {@see DatabaseExceptionInterface} so it flows through the unified
 * persistence-failure strategy (RFC-022 §7.3) like any other driver error.
 */
interface UnauthenticatedAccessExceptionInterface extends DatabaseExceptionInterface {}
