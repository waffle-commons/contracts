<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Console\Exception;

/**
 * Thrown by `ConsoleApplicationInterface::find()` when the requested command
 * name does not resolve to a registered command.
 */
interface CommandNotFoundExceptionInterface extends ConsoleExceptionInterface
{
    /** The command name that was requested but could not be resolved. */
    public function getRequestedCommand(): string;
}
