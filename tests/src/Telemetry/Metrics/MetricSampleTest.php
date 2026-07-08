<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Telemetry\Metrics;

use PHPUnit\Framework\Attributes\CoversClass;
use Waffle\Commons\Contracts\Telemetry\Metrics\Enum\MetricType;
use Waffle\Commons\Contracts\Telemetry\Metrics\MetricSample;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(MetricSample::class)]
#[CoversClass(MetricType::class)]
final class MetricSampleTest extends AbstractTestCase
{
    public function testConstructorAssignsEveryField(): void
    {
        $sample = new MetricSample(
            name: 'waffle_http_requests_total',
            type: MetricType::Counter,
            value: 42.0,
            labels: ['method' => 'GET'],
            help: 'Total HTTP requests served.',
        );

        static::assertSame('waffle_http_requests_total', $sample->name);
        static::assertSame(MetricType::Counter, $sample->type);
        static::assertSame(42.0, $sample->value);
        static::assertSame(['method' => 'GET'], $sample->labels);
        static::assertSame('Total HTTP requests served.', $sample->help);
    }

    public function testLabelsAndHelpDefaultToEmpty(): void
    {
        $sample = new MetricSample('waffle_memory_bytes', MetricType::Gauge, 1024.0);

        static::assertSame([], $sample->labels);
        static::assertSame('', $sample->help);
    }

    public function testMetricTypeBackingValues(): void
    {
        static::assertSame('counter', MetricType::Counter->value);
        static::assertSame('gauge', MetricType::Gauge->value);
        static::assertSame('histogram', MetricType::Histogram->value);
    }
}
