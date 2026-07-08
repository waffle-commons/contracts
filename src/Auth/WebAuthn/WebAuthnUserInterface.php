<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\WebAuthn;

/**
 * The user a WebAuthn registration ceremony enrols a passkey for (AUTH-01).
 *
 * Maps to a WebAuthn `PublicKeyCredentialUserEntity`: a stable, opaque user
 * handle plus the human-facing identifiers a passkey is labelled with. The
 * handle MUST NOT contain personally identifying information (WebAuthn §4) — use
 * a random or surrogate id, never an email.
 */
interface WebAuthnUserInterface
{
    /**
     * Opaque, stable user handle (the credential's `user.id`). Never empty,
     * never PII.
     */
    public function id(): string;

    /**
     * Machine-facing account name (e.g. the login/username).
     */
    public function name(): string;

    /**
     * Human-facing display name shown by the authenticator UI.
     */
    public function displayName(): string;
}
