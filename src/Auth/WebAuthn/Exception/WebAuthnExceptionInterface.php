<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\WebAuthn\Exception;

use Waffle\Commons\Contracts\Auth\Exception\AuthExceptionInterface;

/**
 * Marker for every WebAuthn (passkey) failure (AUTH-01).
 *
 * Sits under the Universal Authentication Bridge's exception tree so a
 * `catch (AuthExceptionInterface)` covers passkey failures alongside JWT, HMAC,
 * and OAuth ones.
 */
interface WebAuthnExceptionInterface extends AuthExceptionInterface {}
