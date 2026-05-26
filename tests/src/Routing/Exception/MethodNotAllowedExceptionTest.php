<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Routing\Exception;

use Exception;
use Waffle\Commons\Contracts\Exception\WaffleExceptionInterface;
use Waffle\Commons\Contracts\Routing\Exception\MethodNotAllowedException;
use Waffle\Commons\Contracts\Routing\Exception\MethodNotAllowedExceptionInterface;
use WaffleTests\Commons\Contracts\AbstractTestCase;

/**
 * Tests for the MethodNotAllowedException exception class.
 */
final class MethodNotAllowedExceptionTest extends AbstractTestCase
{
    /**
     * Tests the constructor with default values.
     */
    public function testDefaultConstructor(): void
    {
        // --- Act ---
        $exception = new MethodNotAllowedException(['GET', 'POST']);

        // --- Assert ---
        static::assertInstanceOf(MethodNotAllowedExceptionInterface::class, $exception);
        static::assertInstanceOf(WaffleExceptionInterface::class, $exception);
        static::assertSame('The requested HTTP method is not allowed.', $exception->getMessage());
        static::assertSame(405, $exception->getCode());
        static::assertSame(['GET', 'POST'], $exception->getAllowedMethods());
    }

    /**
     * Tests the constructor with custom values.
     */
    public function testCustomMessageAndCode(): void
    {
        // --- Arrange ---
        $previous = new Exception('Previous exception');

        // --- Act ---
        $exception = new MethodNotAllowedException(['PUT'], 'Custom message.', 405, $previous);

        // --- Assert ---
        static::assertSame('Custom message.', $exception->getMessage());
        static::assertSame(405, $exception->getCode());
        static::assertSame(['PUT'], $exception->getAllowedMethods());
        static::assertSame($previous, $exception->getPrevious());
    }
}
