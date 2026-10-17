<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Health;

use Waffle\Commons\Contracts\Health\Enum\HealthStatus;

/**
 * The outcome of one {@see HealthCheckInterface} probe ([OPS-01], RFC-023 §3.1).
 *
 * Binary on purpose (RFC-023 §5.4): up or down, plus a short detail meant for the private report only —
 * the public body never shows it, because dependency topology is reconnaissance data. The probe
 * middleware measures each probe's duration itself; a probe does not report it.
 */
final readonly class HealthResult
{
    private function __construct(
        public HealthStatus $status,
        public string $detail,
    ) {}

    /**
     * The dependency answered as expected.
     */
    public static function up(string $detail = ''): self
    {
        return new self(HealthStatus::Up, $detail);
    }

    /**
     * The dependency failed or timed out; `$detail` says how, for the private report.
     */
    public static function down(string $detail): self
    {
        return new self(HealthStatus::Down, $detail);
    }
}
