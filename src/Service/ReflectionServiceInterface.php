<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Service;

use ReflectionParameter;

/**
 * Contract for the framework's centralized reflection access surface.
 *
 * Concrete implementations MUST be stateless and side-effect free so they
 * can be shared safely across FrankenPHP resident-worker requests.
 */
interface ReflectionServiceInterface
{
    /**
     * @param class-string $attributeName
     */
    public function hasAttribute(string $className, string $attributeName): bool;

    /**
     * @param class-string|object $target
     * @return list<ReflectionParameter>
     */
    public function getMethodParameters(string|object $target, string $method): array;

    /**
     * @param class-string $className
     * @return list<ReflectionParameter>|null
     */
    public function getConstructorParameters(string $className): ?array;

    /**
     * @param class-string         $className
     * @param array<string, mixed> $namedArgs
     */
    public function newInstance(string $className, array $namedArgs = []): object;
}
