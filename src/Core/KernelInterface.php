<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Waffle\Commons\Contracts\Container\ContainerInterface;

/**
 * The Kernel is the heart of the application.
 * It is responsible for booting the system and handling HTTP requests.
 */
interface KernelInterface
{
    /**
     * The service container the kernel resolves its collaborators from.
     *
     * Readable so that a test bridge can swap in test doubles between boot() and
     * configure(), before the container locks ([CARRY-04]). Application code
     * receives its dependencies through constructors and never uses this
     * property as a service locator.
     */
    public ContainerInterface $container { get; }

    /**
     * Boots the kernel and initializes environment/configuration.
     */
    public function boot(): static;

    /**
     * Configures the system (container, security, routes).
     */
    public function configure(): void;

    /**
     * Handles a Request and converts it into a Response.
     *
     * @param ServerRequestInterface $request The incoming HTTP request.
     * @return ResponseInterface The generated HTTP response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface;

    /**
     * Clean application state between two requests.
     * Necessary to avoid data leaks between requests (User Context) in Worker mode.
     */
    public function reset(): void;
}
