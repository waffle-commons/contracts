<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Token;

use Waffle\Commons\Contracts\Auth\Exception\InvalidTokenExceptionInterface;

/**
 * Resolves the verification key material for a token signature
 * (RFC-021 §4.4).
 *
 * Two shipped strategies:
 *  - static — a configured shared secret (HS256) or PEM public key (RS256);
 *  - JWKS — the provider's JSON Web Key Set, fetched over PSR-18, selected
 *    by `kid`, converted to PEM, and cached in an injected PSR-16 cache.
 *
 * The resolver returns raw key material; algorithm/key type consistency is
 * enforced by the validator.
 */
interface KeyResolverInterface
{
    /**
     * Returns the key material (shared secret, or PEM-encoded public key)
     * for the given algorithm and optional key id.
     *
     * @param string      $algorithm The token's declared algorithm
     *                               (e.g. `HS256`, `RS256`).
     * @param string|null $keyId     The token header `kid`, when present.
     *
     * @throws InvalidTokenExceptionInterface When no key can be resolved for
     *                                        the pair (unknown `kid`,
     *                                        unsupported algorithm,
     *                                        unreachable key set).
     */
    public function resolve(string $algorithm, ?string $keyId = null): string;
}
