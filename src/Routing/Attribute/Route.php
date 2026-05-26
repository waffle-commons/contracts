<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Routing\Attribute;

use Attribute;

/**
 * PHP attribute to declare a route and its associated HTTP methods.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final readonly class Route
{
    /**
     * @param string $path The route path or pattern.
     * @param array<string> $methods Allowed HTTP methods (e.g. ['GET', 'POST']). If empty, accepts all.
     * @param string|null $name The unique name of the route.
     * @param array<mixed>|null $arguments Metadata about arguments.
     * @param int $priority Match priority of the route (higher evaluated first).
     */
    public function __construct(
        public string $path,
        public array $methods = ['GET'],
        public ?string $name = null,
        public ?array $arguments = null,
        public int $priority = 0,
    ) {}
}
