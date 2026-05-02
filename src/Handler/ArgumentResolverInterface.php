<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Handler;

use Psr\Http\Message\ServerRequestInterface;

interface ArgumentResolverInterface
{
    /**
     * Resolves arguments for a controller method.
     *
     * @param string|object $controller The controller instance or class name.
     * @param string $method The method name.
     * @param ServerRequestInterface $request The current HTTP request.
     * @param array<string, mixed> $routeParams Route parameters from the matched route.
     * @return array<int, mixed> Resolved arguments in order.
     */
    public function resolve(string|object $controller, string $method, ServerRequestInterface $request, array $routeParams): array;
}
