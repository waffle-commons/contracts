<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Console\Enum;

/**
 * Verbosity levels for Console output streams.
 *
 * Implementations of `OutputInterface` MUST gate writes by comparing the message's
 * `$threshold` to the output's current `getVerbosity()`: a message is emitted only
 * when the output verbosity is greater than or equal to the message threshold.
 */
enum Verbosity: int
{
    case QUIET = 0;
    case NORMAL = 1;
    case VERBOSE = 2;
    case VERY_VERBOSE = 3;
    case DEBUG = 4;

    /**
     * Returns true when a message gated at $threshold should be emitted under this
     * verbosity level. Provided as a helper so implementations don't reimplement
     * the comparison rule (and so the rule is testable here).
     */
    public function permits(self $threshold): bool
    {
        return $this->value >= $threshold->value;
    }
}
