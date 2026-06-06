<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth;

use Waffle\Commons\Contracts\Service\ResettableInterface;

/**
 * Request-scoped holder of the authenticated identity (RFC-021 §4.1).
 *
 * This is the ONLY mutable service of the authentication layer. To honour the
 * FrankenPHP resident-worker mandate it extends `ResettableInterface`: the
 * kernel/container calls `reset()` between requests, guaranteeing that no
 * identity ever leaks from one request into the next.
 *
 * The context also records the original client IP (from
 * `ServerRequestInterface::getServerParams()['REMOTE_ADDR']`), which the HMAC
 * assertion scheme folds into signed payloads for IP-binding (RFC-021 §4.3).
 */
interface SecurityContextInterface extends ResettableInterface
{
    /**
     * Stores the verified identity (and optionally the original client IP)
     * for the remainder of the current request.
     */
    public function authenticate(UserIdentityInterface $identity, ?string $clientIp = null): void;

    /** True when a verified identity is held for the current request. */
    public function isAuthenticated(): bool;

    /** The verified identity, or null for anonymous requests. */
    public function getIdentity(): ?UserIdentityInterface;

    /** The original client IP recorded at authentication time, or null. */
    public function getClientIp(): ?string;
}
