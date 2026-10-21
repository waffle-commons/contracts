<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Migration;

use Waffle\Commons\Contracts\Data\Migration\Enum\MigrationStatus;

/**
 * One row of a migration status report ([OPS-03], RFC-014): a version, where it stands, and whether
 * a down script exists to roll it back.
 */
final readonly class MigrationState
{
    /**
     * @param string|null $appliedAt The ledger's `applied_at` value as the driver returns it (its text
     *        format differs between engines); null while the version is pending.
     */
    public function __construct(
        public string $version,
        public MigrationStatus $status,
        public bool $reversible,
        public ?string $appliedAt = null,
    ) {}
}
