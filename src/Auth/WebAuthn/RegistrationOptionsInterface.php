<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\WebAuthn;

/**
 * Server-issued options for a WebAuthn registration (attestation) ceremony
 * (AUTH-01).
 *
 * Maps to a `PublicKeyCredentialCreationOptions`. The server creates these,
 * persists the {@see self::challenge()} against the pending ceremony, and sends
 * {@see self::toJson()} to the browser's `navigator.credentials.create()`. The
 * same options must be replayed to the verifier to bind the attestation to its
 * challenge.
 */
interface RegistrationOptionsInterface
{
    /**
     * The single-use, cryptographically-random challenge (base64url), bound to
     * this ceremony and replayed at verification to defeat replay attacks.
     */
    public function challenge(): string;

    /**
     * The options as a JSON-serializable associative array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;

    /**
     * The options serialized as JSON for the client `create()` call.
     */
    public function toJson(): string;
}
