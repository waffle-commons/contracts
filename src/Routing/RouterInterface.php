<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Routing;

use Psr\Http\Message\ServerRequestInterface;
use Waffle\Commons\Contracts\Container\ContainerInterface;

interface RouterInterface
{
    public function boot(ContainerInterface $container): self;

    /**
     * @param ContainerInterface $container
     * @param ServerRequestInterface $req
     * @param array{
     *        classname: class-string,
     *        method: string,
     *        arguments: array<string, mixed>,
     *        path: string,
     *        name: non-falsy-string
     *   } $route
     * @return bool
     */
    public function match(ContainerInterface $container, ServerRequestInterface $req, array $route): bool;

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
