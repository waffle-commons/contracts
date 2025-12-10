<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Routing;

use Psr\Http\Message\ServerRequestInterface;
use Waffle\Commons\Contracts\Container\ContainerInterface;

interface RouterInterface
{
    public function boot(ContainerInterface $container): self;

    /**
     * Matches the current request against registered routes.
     *
     * @param ServerRequestInterface $request
     * @return array{
     *        classname: class-string,
     *        method: string,
     *        arguments: array<string, mixed>,
     *        path: string,
     *        name: non-falsy-string,
     *        params?: array<string, mixed>
     *   }|null Returns the route array if matched, null otherwise.
     */
    public function matchRequest(ServerRequestInterface $request): null|array;

    /**
     * @return array<array-key, array{
     *       classname: class-string,
     *       method: string,
     *       arguments: array<string, mixed>,
     *       path: string,
     *       name: non-falsy-string
     *  }>
     */
    public function getRoutes(): array;
}
