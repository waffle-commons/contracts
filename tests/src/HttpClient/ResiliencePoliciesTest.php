<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\HttpClient;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Waffle\Commons\Contracts\HttpClient\RetryPolicy;
use Waffle\Commons\Contracts\HttpClient\TimeoutPolicy;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(TimeoutPolicy::class)]
#[CoversClass(RetryPolicy::class)]
final class ResiliencePoliciesTest extends AbstractTestCase
{
    public function testTodaysCeilingsAreTheTimeoutDefaults(): void
    {
        $policy = new TimeoutPolicy();

        static::assertSame(1000, $policy->connectMs);
        static::assertSame(10_000, $policy->totalMs);
        static::assertSame(30_000, new TimeoutPolicy(30_000, 120_000)->connectMs);
    }

    /**
     * @return iterable<string, array{int, int}>
     */
    public static function invalidTimeouts(): iterable
    {
        yield 'no connect timeout' => [0, 1000];
        yield 'a connect timeout above the ceiling' => [30_001, 1000];
        yield 'no total timeout' => [1000, 0];
        yield 'a total timeout above the ceiling' => [1000, 120_001];
    }

    #[DataProvider('invalidTimeouts')]
    public function testNoInfiniteTimeoutCanBeBuilt(int $connectMs, int $totalMs): void
    {
        $this->expectException(InvalidArgumentException::class);

        new TimeoutPolicy($connectMs, $totalMs);
    }

    public function testRetryDefaults(): void
    {
        $policy = new RetryPolicy();

        static::assertSame(3, $policy->maxAttempts);
        static::assertSame(100, $policy->baseDelayMs);
        static::assertSame(2000, $policy->maxDelayMs);
        static::assertSame(15_000, $policy->budgetMs);
        static::assertFalse($policy->retryNonIdempotent);
        static::assertSame([429, 502, 503, 504], RetryPolicy::RETRYABLE_STATUSES);
    }

    /**
     * @return iterable<string, array{int, int, int, int}>
     */
    public static function invalidRetries(): iterable
    {
        yield 'no attempt' => [0, 100, 2000, 1000];
        yield 'too many attempts' => [11, 100, 2000, 1000];
        yield 'no base delay' => [3, 0, 2000, 1000];
        yield 'no cap' => [3, 100, 0, 1000];
        yield 'no budget' => [3, 100, 2000, 0];
    }

    #[DataProvider('invalidRetries')]
    public function testRefusesAnUnboundedRetryPolicy(int $attempts, int $base, int $cap, int $budget): void
    {
        $this->expectException(InvalidArgumentException::class);

        new RetryPolicy($attempts, $base, $cap, $budget);
    }
}
