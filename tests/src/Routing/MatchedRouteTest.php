<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Routing;

use Waffle\Commons\Contracts\Routing\MatchedRoute;
use WaffleTests\Commons\Contracts\AbstractTestCase;

final class MatchedRouteTest extends AbstractTestCase
{
    public function testConstructorAssignsEveryField(): void
    {
        $route = new MatchedRoute(
            className: 'App\\Controller\\UserController',
            method: 'show',
            arguments: ['id' => ['type' => 'int']],
            path: '/users/{id}',
            name: 'user.show',
            params: ['id' => '42'],
        );

        static::assertSame('App\\Controller\\UserController', $route->className);
        static::assertSame('show', $route->method);
        static::assertSame(['id' => ['type' => 'int']], $route->arguments);
        static::assertSame('/users/{id}', $route->path);
        static::assertSame('user.show', $route->name);
        static::assertSame(['id' => '42'], $route->params);
    }

    public function testParamsDefaultsToEmptyArray(): void
    {
        $route = new MatchedRoute(
            className: 'App\\Controller\\HomeController',
            method: 'index',
            arguments: [],
            path: '/',
            name: 'home',
        );

        static::assertSame([], $route->params);
    }

    public function testWithParamsReturnsNewInstanceAndLeavesOriginalUntouched(): void
    {
        $original = new MatchedRoute(
            className: 'App\\Controller\\HomeController',
            method: 'index',
            arguments: ['locale' => ['type' => 'string']],
            path: '/{locale}',
            name: 'home',
        );

        $hydrated = $original->withParams(['locale' => 'fr']);

        static::assertNotSame($original, $hydrated);
        static::assertSame([], $original->params, 'original params must be untouched');
        static::assertSame(['locale' => 'fr'], $hydrated->params);
        static::assertSame($original->className, $hydrated->className);
        static::assertSame($original->method, $hydrated->method);
        static::assertSame($original->arguments, $hydrated->arguments);
        static::assertSame($original->path, $hydrated->path);
        static::assertSame($original->name, $hydrated->name);
    }
}
