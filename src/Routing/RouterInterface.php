<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Routing;

use Psr\Http\Message\ServerRequestInterface;
use Waffle\Commons\Contracts\Container\ContainerInterface;

interface RouterInterface
{
    public function boot(ContainerInterface $container): static;

    /**
     * Matches the current request against registered routes.
     *
     * @return MatchedRoute|null Returns the matched route DTO if a match is found, null otherwise.
     */
    public function matchRequest(ServerRequestInterface $request): ?MatchedRoute;

    /**
     * @return list<MatchedRoute> All discovered routes in declaration order.
     */
    public function getRoutes(): array;
}
