<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\WebAuthn;

use Waffle\Commons\Contracts\Auth\WebAuthn\Exception\InvalidWebAuthnAssertionExceptionInterface;
use Waffle\Commons\Contracts\Auth\WebAuthn\Exception\InvalidWebAuthnRegistrationExceptionInterface;

/**
 * The cryptographic core of WebAuthn (AUTH-01), wrapping an audited library
 * (`web-auth/webauthn-lib`) so the framework never hand-rolls CBOR/COSE/
 * attestation parsing.
 *
 * Implementations are stateless: every call is driven by its arguments and the
 * relying-party configuration injected at construction. Challenge persistence
 * and credential storage live OUTSIDE this contract (in the app's
 * {@see CredentialRepositoryInterface} and challenge store).
 */
interface WebAuthnVerifierInterface
{
    /**
     * Build registration (attestation) options for enrolling a new passkey.
     *
     * @param list<RegisteredCredentialInterface> $existing Already-enrolled
     *        credentials to exclude (prevents double-registration).
     */
    public function createRegistrationOptions(
        WebAuthnUserInterface $user,
        array $existing = [],
    ): RegistrationOptionsInterface;

    /**
     * Verify the authenticator's attestation response against the issued options
     * and return the credential to persist.
     *
     * @throws InvalidWebAuthnRegistrationExceptionInterface When attestation
     *         verification fails (bad challenge, origin, signature, or an
     *         unsupported attestation format).
     */
    public function verifyRegistration(
        RegistrationOptionsInterface $options,
        string $clientResponseJson,
    ): RegisteredCredentialInterface;

    /**
     * Build assertion (login) options.
     *
     * @param list<RegisteredCredentialInterface> $allowed Credentials the user
     *        may assert with; empty enables a usernameless/discoverable login.
     */
    public function createAssertionOptions(array $allowed = []): AssertionOptionsInterface;

    /**
     * Verify the authenticator's assertion response against the issued options
     * and the stored credential, returning the new signature counter to persist.
     *
     * @throws InvalidWebAuthnAssertionExceptionInterface When assertion
     *         verification fails (bad challenge, origin, signature, or a
     *         non-monotonic signature counter signalling a cloned authenticator).
     */
    public function verifyAssertion(
        AssertionOptionsInterface $options,
        string $clientResponseJson,
        RegisteredCredentialInterface $credential,
    ): int;
}
