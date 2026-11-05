<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\RateLimit;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Waffle\Commons\Contracts\RateLimit\RateLimitDecision;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(RateLimitDecision::class)]
final class RateLimitDecisionTest extends AbstractTestCase
{
    public function testAnAllowedCallCarriesTheCountsAndNoRetryAfter(): void
    {
        $decision = new RateLimitDecision(true, 100, 99, 1);

        static::assertTrue($decision->allowed);
        static::assertSame(100, $decision->limit);
        static::assertSame(99, $decision->remaining);
        static::assertSame(1, $decision->resetSeconds);
        static::assertSame(0, $decision->retryAfterSeconds);
        static::assertTrue($decision->enforced);
    }

    public function testADeniedCallCarriesItsRetryAfter(): void
    {
        $decision = new RateLimitDecision(false, 100, 0, 60, 1);

        static::assertFalse($decision->allowed);
        static::assertSame(0, $decision->remaining);
        static::assertSame(1, $decision->retryAfterSeconds);
    }

    public function testACallLetThroughDuringAStorageOutageIsNotEnforced(): void
    {
        $decision = new RateLimitDecision(true, 100, 100, 0, 0, false);

        static::assertTrue($decision->allowed);
        static::assertFalse($decision->enforced);
    }

    /**
     * @return iterable<string, array{bool, int, int, int, int}>
     */
    public static function invalidDecisions(): iterable
    {
        yield 'a limit below one call' => [true, 0, 0, 0, 0];
        yield 'negative remaining calls' => [true, 10, -1, 0, 0];
        yield 'more remaining calls than the limit' => [true, 10, 11, 0, 0];
        yield 'a negative reset' => [true, 10, 5, -1, 0];
        yield 'a negative Retry-After' => [false, 10, 0, 5, -1];
        yield 'an allowed call with a Retry-After' => [true, 10, 5, 5, 3];
        yield 'a denied call without a Retry-After' => [false, 10, 0, 5, 0];
    }

    #[DataProvider('invalidDecisions')]
    public function testRefusesAnInconsistentDecision(
        bool $allowed,
        int $limit,
        int $remaining,
        int $resetSeconds,
        int $retryAfterSeconds,
    ): void {
        $this->expectException(InvalidArgumentException::class);

        new RateLimitDecision($allowed, $limit, $remaining, $resetSeconds, $retryAfterSeconds);
    }
}
