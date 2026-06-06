<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Token;

use Waffle\Commons\Contracts\Auth\Exception\InvalidTokenExceptionInterface;
use Waffle\Commons\Contracts\Auth\UserIdentityInterface;

/**
 * Validates a self-contained bearer token — in Beta 3, a JWS compact JWT
 * (RFC-021 §4.4) — and maps its claims into a verified identity.
 *
 * Mandates:
 *  - the validator is constructed with an explicit algorithm allow-list;
 *    `alg: none` and any non-allow-listed algorithm reject unconditionally;
 *  - key material is type-checked against the algorithm (no HS/RS
 *    confusion);
 *  - the signature is verified BEFORE any claim is read;
 *  - `exp`/`nbf` are enforced (bounded leeway) and the expected `iss` and
 *    `aud` are mandatory configuration.
 */
interface TokenValidatorInterface
{
    /**
     * Validates the token and returns the identity mapped from its claims.
     *
     * @param string      $token         The compact token (e.g. from the
     *                                   `Authorization: Bearer` header).
     * @param string|null $expectedNonce When validating an OIDC ID token,
     *                                   the `nonce` bound to the login
     *                                   transaction; mismatch rejects.
     *
     * @throws InvalidTokenExceptionInterface On any structural, signature,
     *                                        algorithm, or claim failure
     *                                        (HTTP 401).
     */
    public function validate(
        #[\SensitiveParameter]
        string $token,
        ?string $expectedNonce = null,
    ): UserIdentityInterface;
}
