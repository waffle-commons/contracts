<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Telemetry;

use PHPUnit\Framework\Attributes\CoversClass;
use RuntimeException;
use Waffle\Commons\Contracts\Telemetry\Enum\SpanKind;
use Waffle\Commons\Contracts\Telemetry\Enum\SpanStatus;
use Waffle\Commons\Contracts\Telemetry\NullSpan;
use Waffle\Commons\Contracts\Telemetry\NullSpanContext;
use Waffle\Commons\Contracts\Telemetry\NullTracer;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(NullTracer::class)]
#[CoversClass(NullSpan::class)]
#[CoversClass(NullSpanContext::class)]
final class NullTracerTest extends AbstractTestCase
{
    public function testStartSpanReturnsAnInertSpanAndNoActiveContext(): void
    {
        $tracer = new NullTracer();

        $span = $tracer->startSpan('test', SpanKind::Server);

        static::assertInstanceOf(NullSpan::class, $span);
        static::assertNull($tracer->currentContext());
    }

    public function testNullSpanMutatorsAreInertAndReturnAnInvalidContext(): void
    {
        $span = new NullSpan();

        // None of these throw or mutate observable state.
        $span->setAttribute('http.route', '/users/{id}');
        $span->recordException(new RuntimeException('boom'));
        $span->setStatus(SpanStatus::Error);
        $span->end();
        $span->end(); // idempotent

        $context = $span->context();
        static::assertInstanceOf(NullSpanContext::class, $context);
        static::assertFalse($context->isValid());
    }

    public function testNullSpanContextIsTheCanonicalInvalidW3CContext(): void
    {
        $context = new NullSpanContext();

        static::assertSame('00000000000000000000000000000000', $context->traceId());
        static::assertSame('0000000000000000', $context->spanId());
        static::assertSame(0, $context->traceFlags());
        static::assertSame('', $context->traceState());
        static::assertFalse($context->isValid());
        static::assertSame('00-00000000000000000000000000000000-0000000000000000-00', $context->toTraceparent());
    }
}
