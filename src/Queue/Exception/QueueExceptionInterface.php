<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Queue\Exception;

use Throwable;

/**
 * A queue transport failure — the broker is unreachable, refused a command or
 * returned an unreadable message ([QUEUE-01]). Lets callers catch it without
 * coupling to a driver.
 */
interface QueueExceptionInterface extends Throwable {}
