<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Console;

/**
 * Console-subsystem constants (Phase 3 / RFC-012).
 *
 * Domain-specific: avoids the "god `Constant` class" pattern by keeping
 * Console identifiers next to the Console contracts they belong to.
 */
final class Constant
{
    /** Separator between command namespace and verb (e.g. "cache:clear"). */
    public const string COMMAND_NAME_SEPARATOR = ':';

    /** Reserved command name listing all registered commands. */
    public const string COMMAND_LIST = 'list';

    /** Reserved command name printing help text. */
    public const string COMMAND_HELP = 'help';

    /** Default application name surfaced by `getName()`. */
    public const string DEFAULT_APP_NAME = 'Waffle';

    /** Long-form option prefix on the command line (`--verbose`). */
    public const string OPTION_PREFIX_LONG = '--';

    /** Short-form option prefix on the command line (`-v`). */
    public const string OPTION_PREFIX_SHORT = '-';
}
