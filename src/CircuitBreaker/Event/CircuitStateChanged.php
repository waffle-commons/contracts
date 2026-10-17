<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\CircuitBreaker\Event;

use Waffle\Commons\Contracts\CircuitBreaker\Enum\CircuitState;

/**
 * A circuit changed state ([NET-03], RFC-024 §3.2). Dispatched through PSR-14, so listeners in any
 * component react without importing the client that owns the breaker.
 */
final readonly class CircuitStateChanged
{
    /**
     * @param string $circuit The upstream origin the circuit protects, e.g. "https://api.example.com:443".
     */
    public function __construct(
        public string $circuit,
        public CircuitState $from,
        public CircuitState $to,
    ) {}
}
