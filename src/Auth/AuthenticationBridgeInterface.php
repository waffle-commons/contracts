<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth;

use Psr\Http\Message\ServerRequestInterface;
use Waffle\Commons\Contracts\Auth\Exception\AuthenticationExceptionInterface;

/**
 * The Universal Authentication Bridge orchestrator (RFC-021 §3.2).
 *
 * Runs the registered {@see AuthenticatorInterface} schemes against an
 * incoming request, in registration order, applying three strict rules:
 *
 *  1. **First match wins** — the first scheme whose `supports()` returns true
 *     performs the authentication; later schemes are never consulted.
 *  2. **Fail-closed** — a supporting scheme that rejects the credentials
 *     throws; the bridge MUST propagate the exception (no fallback, no silent
 *     anonymous downgrade).
 *  3. **Anonymous is explicit** — when no scheme supports the request the
 *     bridge returns null; route protection remains the job of the
 *     authorization layer (RFC-002).
 *
 * On success the bridge populates the {@see SecurityContextInterface} with the
 * verified identity and the original client IP before returning it.
 */
interface AuthenticationBridgeInterface
{
    /**
     * Authenticates the request through the registered schemes.
     *
     * @return UserIdentityInterface|null The verified identity, or null when
     *                                    the request carries no credentials of
     *                                    any registered scheme (anonymous).
     *
     * @throws AuthenticationExceptionInterface When a supporting scheme
     *                                          rejects the credentials.
     */
    public function authenticate(ServerRequestInterface $request): ?UserIdentityInterface;
}
