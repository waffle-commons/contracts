<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Assertion;

/**
 * Signs identity assertions for the Gateway Assertion Protocol
 * (RFC-021 §4.3).
 *
 * Wire format: `base64url(canonical JSON payload) . hex(HMAC-SHA256)`,
 * where the MAC is computed over the *encoded* payload with the shared
 * secret (`WAFFLE_AUTH_SECRET`).
 *
 * Mandates:
 *  - construction fails (fatal `MissingAuthSecretExceptionInterface`) when
 *    the secret is missing, empty, or shorter than
 *    `Constant::MIN_SECRET_BYTES` — fail-closed boot (RFC-021 §4.2);
 *  - the secret parameter is `#[\SensitiveParameter]`.
 */
interface AssertionSignerInterface
{
    /**
     * Serializes and signs the assertion into the `X-Wfl-Assert-User`
     * header wire format.
     */
    public function sign(UserAssertionInterface $assertion): string;

    /**
     * Computes the keyed IP-binding hash (`iph` claim):
     * `hex(HMAC-SHA256(clientIp, secret))`. Exposed so credential providers
     * can build assertion payloads without ever holding the secret.
     */
    public function hashClientIp(string $clientIp): string;
}
