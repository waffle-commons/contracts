<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\CircuitBreaker;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Waffle\Commons\Contracts\CircuitBreaker\CircuitBreakerPolicy;
use Waffle\Commons\Contracts\CircuitBreaker\CircuitDecision;
use Waffle\Commons\Contracts\CircuitBreaker\Enum\CircuitState;
use Waffle\Commons\Contracts\CircuitBreaker\Event\CircuitStateChanged;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(CircuitBreakerPolicy::class)]
#[CoversClass(CircuitDecision::class)]
#[CoversClass(CircuitStateChanged::class)]
final class CircuitBreakerContractsTest extends AbstractTestCase
{
    public function testPolicyDefaults(): void
    {
        $policy = new CircuitBreakerPolicy();

        static::assertSame(50, $policy->failureRatePercent);
        static::assertSame(10, $policy->minimumCalls);
        static::assertSame(60, $policy->windowSeconds);
        static::assertSame(30, $policy->coolDownSeconds);
        static::assertSame(1, $policy->halfOpenTrials);
    }

    /**
     * @return iterable<string, array{int, int, int, int, int}>
     */
    public static function invalidPolicies(): iterable
    {
        yield 'a zero threshold' => [0, 10, 60, 30, 1];
        yield 'a threshold above 100 %' => [101, 10, 60, 30, 1];
        yield 'no minimum call' => [50, 0, 60, 30, 1];
        yield 'no window' => [50, 10, 0, 30, 1];
        yield 'a window above an hour' => [50, 10, 3601, 30, 1];
        yield 'no cool-down' => [50, 10, 60, 0, 1];
        yield 'a cool-down above an hour' => [50, 10, 60, 3601, 1];
        yield 'no trial call' => [50, 10, 60, 30, 0];
    }

    #[DataProvider('invalidPolicies')]
    public function testRefusesAnUnusablePolicy(int $rate, int $minimum, int $window, int $coolDown, int $trials): void
    {
        $this->expectException(InvalidArgumentException::class);

        new CircuitBreakerPolicy($rate, $minimum, $window, $coolDown, $trials);
    }

    public function testADecisionSaysWhetherItMovedTheCircuit(): void
    {
        static::assertFalse(new CircuitDecision(true, CircuitState::Closed)->isTransition());
        static::assertFalse(new CircuitDecision(true, CircuitState::Closed, CircuitState::Closed)->isTransition());
        static::assertTrue(new CircuitDecision(false, CircuitState::Open, CircuitState::Closed)->isTransition());
    }

    public function testTheEventCarriesTheCircuitAndBothStates(): void
    {
        $event = new CircuitStateChanged('https://api.example.com:443', CircuitState::Closed, CircuitState::Open);

        static::assertSame('https://api.example.com:443', $event->circuit);
        static::assertSame(CircuitState::Closed, $event->from);
        static::assertSame('open', $event->to->value);
    }
}
