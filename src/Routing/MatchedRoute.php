<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Routing;

/**
 * Immutable result of a successful route match.
 *
 * Replaces the legacy nested-array shape previously returned by
 * RouterInterface::matchRequest() and getRoutes(). Construction happens
 * exclusively at the Router boundary (a trusted producer), so validation
 * via Property Hooks is intentionally absent on this DTO.
 */
final readonly class MatchedRoute
{
    /**
     * @param class-string         $className FQCN of the controller bound to this route.
     * @param non-empty-string     $method    Method name on the controller.
     * @param array<string, mixed> $arguments Per-argument metadata from #[Argument] attributes.
     * @param non-falsy-string     $path      Original route path pattern (e.g. "/users/{id}").
     * @param non-falsy-string     $name      Route name from #[Route(name: ...)].
     * @param array<string, mixed> $params    Extracted path-parameter values for this request.
     * @param int                  $priority  Higher matches first; negative values (e.g. -1000)
     *                                        flag catch-all routes that must match last.
     */
    public function __construct(
        public string $className,
        public string $method,
        public array $arguments,
        public string $path,
        public string $name,
        public array $params = [],
        public int $priority = 0,
    ) {}

    /**
     * Returns a copy with the supplied path-parameter values, leaving every other
     * field intact. Used by the Router to attach per-request `params` to a route
     * descriptor that itself only carries the static `arguments` table.
     *
     * @param array<string, mixed> $params
     */
    public function withParams(array $params): self
    {
        return new self(
            className: $this->className,
            method: $this->method,
            arguments: $this->arguments,
            path: $this->path,
            name: $this->name,
            params: $params,
            priority: $this->priority,
        );
    }
}
