<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Console\Exception;

/**
 * Thrown when a command is invoked with malformed or missing required input —
 * e.g. a required positional argument is absent, or an option value fails
 * validation.
 *
 * The corresponding `ExitCode::USAGE` (64) should be returned by the application.
 */
interface InvalidArgumentExceptionInterface extends ConsoleExceptionInterface
{
    /**
     * The offending argument or option name, or null when the failure is not
     * tied to a single named input (e.g. malformed overall syntax).
     */
    public function getArgumentName(): ?string;
}
