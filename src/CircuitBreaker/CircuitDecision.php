<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\CircuitBreaker;

use Waffle\Commons\Contracts\CircuitBreaker\Enum\CircuitState;

/**
 * What the shared circuit state answered ([NET-03]): whether a call may go through, the state after the
 * operation, and the state before it when the operation made the circuit change.
 */
final readonly class CircuitDecision
{
    public function __construct(
        public bool $allowed,
        public CircuitState $state,
        public ?CircuitState $previous = null,
    ) {}

    /** True when this operation moved the circuit from `$previous` to `$state`. */
    public function isTransition(): bool
    {
        return $this->previous !== null && $this->previous !== $this->state;
    }
}
