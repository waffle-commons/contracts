<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Telemetry;

use PHPUnit\Framework\Attributes\CoversClass;
use Waffle\Commons\Contracts\Telemetry\NullSpanContext;
use Waffle\Commons\Contracts\Telemetry\NullTextMapPropagator;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(NullTextMapPropagator::class)]
final class NullTextMapPropagatorTest extends AbstractTestCase
{
    public function testInjectWritesNothingAndExtractReturnsNull(): void
    {
        $propagator = new NullTextMapPropagator();
        $carrier = ['existing' => 'header'];

        $propagator->inject(new NullSpanContext(), $carrier);

        static::assertSame(['existing' => 'header'], $carrier, 'no-op inject must not touch the carrier');
        static::assertNull($propagator->extract(['traceparent' => '00-abc-def-01']));
    }
}
