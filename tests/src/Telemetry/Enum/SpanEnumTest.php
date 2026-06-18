<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Telemetry\Enum;

use PHPUnit\Framework\Attributes\CoversClass;
use Waffle\Commons\Contracts\Telemetry\Enum\SpanKind;
use Waffle\Commons\Contracts\Telemetry\Enum\SpanStatus;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(SpanKind::class)]
#[CoversClass(SpanStatus::class)]
final class SpanEnumTest extends AbstractTestCase
{
    public function testSpanKindBackingValues(): void
    {
        static::assertSame('internal', SpanKind::Internal->value);
        static::assertSame('server', SpanKind::Server->value);
        static::assertSame('client', SpanKind::Client->value);
        static::assertSame('producer', SpanKind::Producer->value);
        static::assertSame('consumer', SpanKind::Consumer->value);
    }

    public function testSpanStatusBackingValues(): void
    {
        static::assertSame('unset', SpanStatus::Unset->value);
        static::assertSame('ok', SpanStatus::Ok->value);
        static::assertSame('error', SpanStatus::Error->value);
    }
}
