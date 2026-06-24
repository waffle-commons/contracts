<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Async\Exception;

use Throwable;

/**
 * Contract for every failure originating in the asynchronous task runner (ASYNC-01).
 *
 * Lets consumers catch deferral failures without coupling to a concrete
 * implementation in the `waffle-commons/async` component.
 */
interface AsyncExceptionInterface extends Throwable {}
