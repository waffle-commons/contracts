<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Health;

use PHPUnit\Framework\Attributes\CoversClass;
use Waffle\Commons\Contracts\Health\Enum\HealthStatus;
use Waffle\Commons\Contracts\Health\HealthResult;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(HealthResult::class)]
final class HealthResultTest extends AbstractTestCase
{
    public function testAnUpResultNeedsNoDetail(): void
    {
        $result = HealthResult::up();

        static::assertSame(HealthStatus::Up, $result->status);
        static::assertSame('', $result->detail);
    }

    public function testAnUpResultMayCarryADetail(): void
    {
        static::assertSame('lease in 2 ms', HealthResult::up('lease in 2 ms')->detail);
    }

    public function testADownResultSaysWhyForThePrivateReport(): void
    {
        $result = HealthResult::down('connection refused');

        static::assertSame(HealthStatus::Down, $result->status);
        static::assertSame('connection refused', $result->detail);
    }

    public function testTheStatusValuesAreTheReportVocabulary(): void
    {
        static::assertSame('up', HealthStatus::Up->value);
        static::assertSame('down', HealthStatus::Down->value);
    }
}
