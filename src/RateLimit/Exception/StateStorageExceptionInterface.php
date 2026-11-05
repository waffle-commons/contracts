<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\RateLimit\Exception;

use Throwable;

/**
 * The shared rate-limit state is unavailable: the storage backend is unreachable or refused an operation
 * ([NET-01]). The limiter catches it to apply its failure mode (`on_storage_failure`), without coupling to
 * the storage implementation.
 */
interface StateStorageExceptionInterface extends Throwable {}
