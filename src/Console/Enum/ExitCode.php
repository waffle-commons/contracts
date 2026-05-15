<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Console\Enum;

/**
 * Standard CLI exit codes (mirrors BSD sysexits(3) where applicable).
 *
 * `execute()` implementations may return either the raw `int` or `ExitCode::SUCCESS->value`.
 * The exit-code contract is "0 = success, non-zero = failure" — semantically distinct
 * non-zero codes help CI/CD pipelines branch on the failure category.
 */
enum ExitCode: int
{
    case SUCCESS = 0;
    case FAILURE = 1;
    case USAGE = 64; // command-line usage error
    case DATA_ERR = 65; // user-supplied input data was malformed
    case NO_INPUT = 66; // a required input file was missing
    case NO_PERM = 77; // insufficient permissions
    case CONFIG = 78; // configuration error

    public function isSuccess(): bool
    {
        return $this === self::SUCCESS;
    }

    public function isFailure(): bool
    {
        return !$this->isSuccess();
    }
}
