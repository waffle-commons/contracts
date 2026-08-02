<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Resolves the domain subject under decision for the current request (SEC-05).
 *
 * The security layer's authorization container invokes the resolver
 * post-routing / pre-dispatch: the matched route's parameters are already
 * available as PSR-7 request attributes, but no controller argument has been
 * hydrated yet. Resolution is LAZY and voter-gated — the resolver runs only
 * when the dispatched action carries at least one `#[Voter]`, so public,
 * unvoted actions never invoke it (no hydration cost for a discarded subject,
 * and a failed lookup can never deny a public route). Turning a route
 * parameter (e.g. an `{id}` segment) into the actual domain entity or model
 * is the resolver's job — the security layer never touches persistence
 * itself. The returned value is threaded into every voter as `$subject`
 * ({@see VoterInterface::decide()}), taking precedence over the bare request,
 * so voters can express true object-level (IDOR / ownership) rules. A subject
 * the caller already resolved and passed explicitly to the authorization
 * entry point takes precedence over this resolver.
 *
 * Fail-closed expectation: when resolution fails (unknown identifier, backend
 * error, malformed parameter), implementations MUST throw — on a voted route
 * the caller turns any resolver failure into a denied request. Returning null
 * is reserved for routes that genuinely carry no resource (voting then falls
 * back to the request shape); it MUST NOT be used to swallow a resolution
 * error.
 *
 * Implementations MUST be stateless (FrankenPHP worker mode): resolve
 * everything from the given request, never from retained per-request state.
 */
interface SubjectResolverInterface
{
    /**
     * Resolves the hydrated domain subject for the matched route.
     *
     * @param ServerRequestInterface $request The routed request (route parameters are request attributes).
     * @return mixed The domain subject under decision, or null when the route carries no resource.
     * @throws \Throwable When resolution fails — the caller MUST deny the request (fail-closed).
     */
    public function resolve(ServerRequestInterface $request): mixed;
}
