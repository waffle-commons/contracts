<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Exception;

use Throwable;

/**
 * Contract for every failure originating in the data / persistence layer.
 *
 * Concrete drivers MUST rethrow native backend errors — a `PDOException`, a
 * dropped-socket network failure, a payload encoding error, etc. — wrapped in an
 * implementation of this interface, so consumers can catch persistence failures
 * without coupling to a specific driver.
 */
interface DatabaseExceptionInterface extends Throwable
{
    /**
     * The ANSI SQLSTATE associated with the failure when the backend provides
     * one (relational drivers), or null for backends that do not (Firestore,
     * flat-file, network-level loss).
     */
    public function getSqlState(): ?string;
}
