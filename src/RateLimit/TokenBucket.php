<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\RateLimit;

use InvalidArgumentException;

/**
 * A token bucket ([NET-01], RFC-017 §3.1): it holds at most `$capacity` tokens and refills completely in
 * `$periodSeconds`, one token every `$periodSeconds / $capacity` seconds.
 *
 * "100 requests a minute" is `new TokenBucket(100, 60)`; the capacity is also the largest burst a client
 * may send at once.
 */
final class TokenBucket
{
    /** The longest refill period: one day. */
    public const int MAX_PERIOD_SECONDS = 86_400;

    public function __construct(
        public private(set) int $capacity {
            set(int $value) {
                if ($value < 1) {
                    throw new InvalidArgumentException('A token bucket holds at least one token.');
                }

                $this->capacity = $value;
            }
        },
        public private(set) int $periodSeconds {
            set(int $value) {
                if ($value < 1 || $value > self::MAX_PERIOD_SECONDS) {
                    throw new InvalidArgumentException('A token bucket refills in 1 to 86400 seconds.');
                }

                $this->periodSeconds = $value;
            }
        },
    ) {}
}
