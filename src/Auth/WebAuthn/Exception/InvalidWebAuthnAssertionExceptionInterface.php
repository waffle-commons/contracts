<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\WebAuthn\Exception;

use Waffle\Commons\Contracts\Auth\Exception\AuthenticationExceptionInterface;

/**
 * Raised when a WebAuthn assertion (login) response fails verification (AUTH-01):
 * wrong challenge or origin, a bad signature, an unknown credential, or a
 * non-monotonic signature counter signalling a cloned authenticator.
 *
 * Also an {@see AuthenticationExceptionInterface} so the Universal Authentication
 * Bridge treats a failed passkey login as a fail-closed 401, exactly like any
 * other rejected inbound credential.
 */
interface InvalidWebAuthnAssertionExceptionInterface extends
    WebAuthnExceptionInterface,
    AuthenticationExceptionInterface {}
