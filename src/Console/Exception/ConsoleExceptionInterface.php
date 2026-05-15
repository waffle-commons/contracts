<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Console\Exception;

use Throwable;

/**
 * Marker interface for any failure raised by the Console subsystem.
 *
 * The `waffle` binary's top-level handler catches this marker to convert the
 * exception into a non-zero exit code and a structured stderr message.
 */
interface ConsoleExceptionInterface extends Throwable {}
