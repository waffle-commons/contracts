<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\RateLimit;

use InvalidArgumentException;

/**
 * What a rate limiter decided for one call ([NET-01]), with what the response headers need:
 * `RateLimit-Limit`, `RateLimit-Remaining` and `RateLimit-Reset` on every response, `Retry-After` on a
 * `429`.
 */
final class RateLimitDecision
{
    /**
     * @param bool $allowed           Whether the call may go through.
     * @param int  $limit             The bucket capacity (`RateLimit-Limit`).
     * @param int  $remaining         The tokens left after this call (`RateLimit-Remaining`), 0 to `$limit`.
     * @param int  $resetSeconds      The seconds until the bucket is full again (`RateLimit-Reset`).
     * @param int  $retryAfterSeconds When denied, the seconds until the call's cost fits (`Retry-After`), at
     *                                least 1; 0 when allowed.
     * @param bool $enforced          False when the limiter could not reach its storage and let the call
     *                                through (`on_storage_failure: open`): the counts are then unknown and
     *                                the `RateLimit-*` headers are omitted.
     */
    public function __construct(
        public private(set) bool $allowed,
        public private(set) int $limit {
            set(int $value) {
                if ($value < 1) {
                    throw new InvalidArgumentException('A rate limit allows at least one call.');
                }

                $this->limit = $value;
            }
        },
        public private(set) int $remaining {
            set(int $value) {
                if ($value < 0) {
                    throw new InvalidArgumentException(
                        'A rate limit decision cannot leave a negative number of calls.',
                    );
                }

                $this->remaining = $value;
            }
        },
        public private(set) int $resetSeconds {
            set(int $value) {
                if ($value < 0) {
                    throw new InvalidArgumentException('A rate limit cannot reset in negative time.');
                }

                $this->resetSeconds = $value;
            }
        },
        public private(set) int $retryAfterSeconds = 0 {
            set(int $value) {
                if ($value < 0) {
                    throw new InvalidArgumentException('Retry-After cannot be negative.');
                }

                $this->retryAfterSeconds = $value;
            }
        },
        public private(set) bool $enforced = true,
    ) {
        if ($this->remaining > $this->limit) {
            throw new InvalidArgumentException('A rate limit decision cannot leave more calls than its limit.');
        }

        if ($this->allowed === $this->retryAfterSeconds > 0) {
            throw new InvalidArgumentException(
                'A denied call carries a Retry-After of at least 1 second; an allowed call none.',
            );
        }
    }
}
