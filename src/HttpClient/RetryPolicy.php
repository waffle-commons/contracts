<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\HttpClient;

use InvalidArgumentException;

/**
 * Bounded retries for outbound calls ([NET-02], RFC-024 §3.1).
 *
 * A transport failure or a `429`/`502`/`503`/`504` is retried with exponential backoff and full jitter, up
 * to `$maxAttempts` attempts in all, and no wait starts once `$budgetMs` would be exceeded. Only idempotent
 * methods (RFC 9110: GET, HEAD, OPTIONS, PUT, DELETE) are retried unless `$retryNonIdempotent` is set. A
 * `Retry-After` may exceed `$maxDelayMs` when it fits the remaining budget (RFC-024 §5.4).
 */
final class RetryPolicy
{
    /** @var list<int> */
    public const array RETRYABLE_STATUSES = [429, 502, 503, 504];

    public function __construct(
        public private(set) int $maxAttempts = 3 {
            set(int $value) {
                if ($value < 1 || $value > 10) {
                    throw new InvalidArgumentException('A retry policy allows 1 to 10 attempts.');
                }

                $this->maxAttempts = $value;
            }
        },
        public private(set) int $baseDelayMs = 100 {
            set(int $value) {
                if ($value < 1) {
                    throw new InvalidArgumentException('A backoff base delay is at least 1 ms.');
                }

                $this->baseDelayMs = $value;
            }
        },
        public private(set) int $maxDelayMs = 2000 {
            set(int $value) {
                if ($value < 1) {
                    throw new InvalidArgumentException('A backoff cap is at least 1 ms.');
                }

                $this->maxDelayMs = $value;
            }
        },
        public private(set) int $budgetMs = 15_000 {
            set(int $value) {
                if ($value < 1) {
                    throw new InvalidArgumentException('A retry budget is at least 1 ms.');
                }

                $this->budgetMs = $value;
            }
        },
        public private(set) bool $retryNonIdempotent = false,
    ) {}
}
