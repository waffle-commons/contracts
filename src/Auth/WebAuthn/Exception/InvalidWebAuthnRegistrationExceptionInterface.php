<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\WebAuthn\Exception;

/**
 * Raised when a WebAuthn attestation (registration) response fails verification
 * (AUTH-01): wrong challenge or origin, a bad attestation signature, or an
 * unsupported attestation format. Fail-closed — the credential is never enrolled.
 */
interface InvalidWebAuthnRegistrationExceptionInterface extends WebAuthnExceptionInterface {}
