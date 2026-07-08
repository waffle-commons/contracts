<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\WebAuthn;

/**
 * Persistence boundary for enrolled passkeys (AUTH-01).
 *
 * This is the ONLY stateful part of the WebAuthn surface and it lives in the
 * application's storage (a database, Redis, …), never in worker memory — the
 * authenticator and verifier stay stateless across requests. Implementations are
 * provided by the integrating app and injected into the ceremony/authenticator.
 */
interface CredentialRepositoryInterface
{
    /**
     * Locate a stored credential by its (base64url) credential id, or null when
     * unknown.
     */
    public function findByCredentialId(string $credentialId): ?RegisteredCredentialInterface;

    /**
     * All credentials enrolled for the given user handle, in enrolment order.
     *
     * @return list<RegisteredCredentialInterface>
     */
    public function findByUserHandle(string $userHandle): array;

    /**
     * Persist a freshly registered credential.
     */
    public function save(RegisteredCredentialInterface $credential): void;

    /**
     * Advance the stored signature counter after a verified assertion (clone
     * detection); a no-op for an unknown credential id.
     */
    public function updateSignCount(string $credentialId, int $signCount): void;
}
