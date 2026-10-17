<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\RateLimit;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Waffle\Commons\Contracts\RateLimit\TokenBucket;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(TokenBucket::class)]
final class TokenBucketTest extends AbstractTestCase
{
    public function testDescribesCapacityAndRefillPeriod(): void
    {
        $bucket = new TokenBucket(100, 60);

        static::assertSame(100, $bucket->capacity);
        static::assertSame(60, $bucket->periodSeconds);
    }

    public function testAcceptsTheBoundaries(): void
    {
        $bucket = new TokenBucket(1, TokenBucket::MAX_PERIOD_SECONDS);

        static::assertSame(1, $bucket->capacity);
        static::assertSame(86_400, $bucket->periodSeconds);
    }

    /**
     * @return iterable<string, array{int}>
     */
    public static function invalidCapacities(): iterable
    {
        yield 'zero' => [0];
        yield 'negative' => [-5];
    }

    #[DataProvider('invalidCapacities')]
    public function testRefusesAnEmptyBucket(int $capacity): void
    {
        $this->expectException(InvalidArgumentException::class);

        new TokenBucket($capacity, 60);
    }

    /**
     * @return iterable<string, array{int}>
     */
    public static function invalidPeriods(): iterable
    {
        yield 'zero' => [0];
        yield 'negative' => [-1];
        yield 'longer than a day' => [86_401];
    }

    #[DataProvider('invalidPeriods')]
    public function testRefusesARefillPeriodOutsideOneSecondToOneDay(int $periodSeconds): void
    {
        $this->expectException(InvalidArgumentException::class);

        new TokenBucket(10, $periodSeconds);
    }
}
