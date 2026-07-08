<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\WebAuthn;

/**
 * A passkey enrolled for a user — the persistent product of a successful
 * registration ceremony (AUTH-01).
 *
 * Maps to a `PublicKeyCredentialSource`. Stored by a
 * {@see CredentialRepositoryInterface} and replayed during assertion to verify
 * the signature and enforce the monotonic signature counter (clone detection).
 */
interface RegisteredCredentialInterface
{
    /**
     * The credential id (base64url) the authenticator returns on assertion.
     */
    public function credentialId(): string;

    /**
     * The COSE-encoded public key (base64url) used to verify assertions.
     */
    public function publicKey(): string;

    /**
     * The opaque user handle this credential belongs to.
     */
    public function userHandle(): string;

    /**
     * The last observed signature counter; a new assertion MUST report a higher
     * value or zero, otherwise the authenticator may be cloned.
     */
    public function signCount(): int;

    /**
     * Hints about how the authenticator can be reached (`usb`, `nfc`,
     * `internal`, …).
     *
     * @return list<string>
     */
    public function transports(): array;
}
