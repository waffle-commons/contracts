<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Telemetry\Metrics;

use PHPUnit\Framework\Attributes\CoversClass;
use Waffle\Commons\Contracts\Telemetry\Metrics\NullMetricsRegistry;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(NullMetricsRegistry::class)]
final class NullMetricsRegistryTest extends AbstractTestCase
{
    public function testEveryRecorderIsInert(): void
    {
        $this->expectNotToPerformAssertions();

        $registry = new NullMetricsRegistry();
        $registry->increment('waffle_http_requests_total');
        $registry->increment('waffle_http_requests_total', 2.0, ['status' => '500']);
        $registry->observe('waffle_http_request_duration_seconds', 0.012);
        $registry->gauge('waffle_memory_bytes', 1024.0);
    }
}
