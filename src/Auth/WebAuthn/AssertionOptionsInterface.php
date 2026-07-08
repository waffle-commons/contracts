<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\WebAuthn;

/**
 * Server-issued options for a WebAuthn authentication (assertion) ceremony
 * (AUTH-01).
 *
 * Maps to a `PublicKeyCredentialRequestOptions`. The server creates these,
 * persists the {@see self::challenge()} against the pending login, and sends
 * {@see self::toJson()} to the browser's `navigator.credentials.get()`. The same
 * options must be replayed to the verifier to bind the assertion to its
 * challenge.
 */
interface AssertionOptionsInterface
{
    /**
     * The single-use, cryptographically-random challenge (base64url), bound to
     * this login attempt and replayed at verification to defeat replay attacks.
     */
    public function challenge(): string;

    /**
     * The options as a JSON-serializable associative array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;

    /**
     * The options serialized as JSON for the client `get()` call.
     */
    public function toJson(): string;
}
