<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\CircuitBreaker;

use InvalidArgumentException;

/**
 * When a circuit opens and how it recovers ([NET-03], RFC-024 §3.2).
 *
 * Closed → open when, within a window of `$windowSeconds`, at least `$minimumCalls` calls were recorded and
 * `$failureRatePercent` % or more of them failed. Open → half-open after `$coolDownSeconds`. Half-open admits
 * `$halfOpenTrials` trial calls: a success closes the circuit, a failure opens it again.
 */
final class CircuitBreakerPolicy
{
    public function __construct(
        public private(set) int $failureRatePercent = 50 {
            set(int $value) {
                if ($value < 1 || $value > 100) {
                    throw new InvalidArgumentException('A failure-rate threshold lies between 1 and 100 %.');
                }

                $this->failureRatePercent = $value;
            }
        },
        public private(set) int $minimumCalls = 10 {
            set(int $value) {
                if ($value < 1) {
                    throw new InvalidArgumentException('A circuit needs at least one call before it can open.');
                }

                $this->minimumCalls = $value;
            }
        },
        public private(set) int $windowSeconds = 60 {
            set(int $value) {
                if ($value < 1 || $value > 3600) {
                    throw new InvalidArgumentException('A failure window lasts 1 to 3600 seconds.');
                }

                $this->windowSeconds = $value;
            }
        },
        public private(set) int $coolDownSeconds = 30 {
            set(int $value) {
                if ($value < 1 || $value > 3600) {
                    throw new InvalidArgumentException('A cool-down lasts 1 to 3600 seconds.');
                }

                $this->coolDownSeconds = $value;
            }
        },
        public private(set) int $halfOpenTrials = 1 {
            set(int $value) {
                if ($value < 1) {
                    throw new InvalidArgumentException('A half-open circuit admits at least one trial call.');
                }

                $this->halfOpenTrials = $value;
            }
        },
    ) {}
}
