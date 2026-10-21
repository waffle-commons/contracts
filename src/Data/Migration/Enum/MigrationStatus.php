<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Migration\Enum;

/**
 * Where one migration version stands against the ledger ([OPS-03], RFC-014).
 */
enum MigrationStatus: string
{
    /** Recorded in the ledger and its script is on disk. */
    case Applied = 'applied';
    /** On disk, not yet recorded: the next `db:migrate` applies it. */
    case Pending = 'pending';
    /** Recorded in the ledger, but its script is no longer on disk. */
    case Missing = 'missing';
}
