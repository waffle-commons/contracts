<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security;

use Waffle\Commons\Contracts\Auth\SecurityContextInterface;

/**
 * The VoterInterface defines the mandatory contract for all security voters
 * and hierarchy levels in the Waffle ecosystem.
 */
interface VoterInterface
{
    /**
     * Decides whether the security requirement is met for the current request.
     *
     * Called by the SecureContainer during the route/method authorization phase.
     * The voter receives the request-scoped security context (the authenticated
     * identity, roles and client IP — already populated by the authentication
     * bridge) so ownership / IDOR rules can be expressed; $subject carries the
     * resource under decision (or the PSR-7 request when no resource is resolved).
     *
     * Implementations MUST be stateless: the SecureContainer resolves voters
     * through the container and may reuse a single instance across requests, so
     * never hold per-request state on a voter — read everything from $ctx/$subject.
     *
     * @param SecurityContextInterface $ctx     Request-scoped identity context (may be unauthenticated).
     * @param mixed                    $subject The resource under decision, or null.
     * @return bool True if access is granted, false otherwise.
     */
    public function decide(SecurityContextInterface $ctx, mixed $subject = null): bool;
}
