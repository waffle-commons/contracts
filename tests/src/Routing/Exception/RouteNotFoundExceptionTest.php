<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Routing\Exception;

use RuntimeException;
use Waffle\Commons\Contracts\Routing\Exception\RouteNotFoundException;
use Waffle\Commons\Contracts\Routing\Exception\RouteNotFoundExceptionInterface;
use WaffleTests\Commons\Contracts\AbstractTestCase;

final class RouteNotFoundExceptionTest extends AbstractTestCase
{
    public function testDefaultsToA404RuntimeException(): void
    {
        $exception = new RouteNotFoundException();

        static::assertInstanceOf(RuntimeException::class, $exception);
        static::assertInstanceOf(RouteNotFoundExceptionInterface::class, $exception);
        static::assertSame('Route not found.', $exception->getMessage());
        static::assertSame(404, $exception->getCode());
        static::assertNull($exception->getPrevious());
    }

    public function testRetainsCustomMessageCodeAndPrevious(): void
    {
        $previous = new RuntimeException('upstream');
        $exception = new RouteNotFoundException('No match for /widgets', 410, $previous);

        static::assertSame('No match for /widgets', $exception->getMessage());
        static::assertSame(410, $exception->getCode());
        static::assertSame($previous, $exception->getPrevious());
    }
}
