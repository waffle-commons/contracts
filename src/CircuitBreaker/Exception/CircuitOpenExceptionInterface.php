<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\CircuitBreaker\Exception;

use Throwable;

/**
 * A call was refused because its circuit is open ([NET-03], RFC-024 §3.2): it failed fast, before any
 * connection. The exception code is the HTTP status the error handler renders (503). It is never retried.
 */
interface CircuitOpenExceptionInterface extends Throwable {}
