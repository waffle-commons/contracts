<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\HttpClient;

use InvalidArgumentException;

/**
 * The timeouts of one outbound transfer ([NET-02], RFC-024 §3.1). No infinite timeout can be built: cURL
 * reads `0` as "no timeout", so the hooks refuse `≤ 0` and anything above the ceilings.
 */
final class TimeoutPolicy
{
    public const int DEFAULT_CONNECT_MS = 1000;

    public const int DEFAULT_TOTAL_MS = 10_000;

    public const int MAX_CONNECT_MS = 30_000;

    public const int MAX_TOTAL_MS = 120_000;

    public function __construct(
        public private(set) int $connectMs = self::DEFAULT_CONNECT_MS {
            set(int $value) {
                if ($value < 1 || $value > self::MAX_CONNECT_MS) {
                    throw new InvalidArgumentException('A connect timeout lies between 1 and 30000 ms.');
                }

                $this->connectMs = $value;
            }
        },
        public private(set) int $totalMs = self::DEFAULT_TOTAL_MS {
            set(int $value) {
                if ($value < 1 || $value > self::MAX_TOTAL_MS) {
                    throw new InvalidArgumentException('A total timeout lies between 1 and 120000 ms.');
                }

                $this->totalMs = $value;
            }
        },
    ) {}
}
