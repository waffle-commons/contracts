<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Routing\Attribute;

use Waffle\Commons\Contracts\Routing\Attribute\Route;
use WaffleTests\Commons\Contracts\AbstractTestCase;

/**
 * Tests for the Route attribute class in contracts.
 */
final class RouteTest extends AbstractTestCase
{
    /**
     * Tests the Route attribute constructor with all its parameters.
     */
    public function testConstructorWithAllParameters(): void
    {
        // --- Arrange ---
        $path = '/items';
        $methods = ['GET', 'POST'];
        $name = 'items_list';
        $arguments = ['id' => 'int'];
        $priority = 10;

        // --- Act ---
        $route = new Route($path, $methods, $name, $arguments, $priority);

        // --- Assert ---
        static::assertSame($path, $route->path);
        static::assertSame($methods, $route->methods);
        static::assertSame($name, $route->name);
        static::assertSame($arguments, $route->arguments);
        static::assertSame($priority, $route->priority);
    }

    /**
     * Tests the constructor with default parameters.
     */
    public function testConstructorWithDefaultParameters(): void
    {
        // --- Arrange ---
        $path = '/default';

        // --- Act ---
        $route = new Route($path);

        // --- Assert ---
        static::assertSame($path, $route->path);
        static::assertSame(['GET'], $route->methods);
        static::assertNull($route->name);
        static::assertNull($route->arguments);
        static::assertSame(0, $route->priority);
    }
}
