<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Serializer\Exception;

use Throwable;

/**
 * A serializer failure (API-02): a payload that does not fit a DTO (also a
 * `ValidationExceptionInterface`), a malformed or oversized document, or a class
 * the serializer does not handle. Lets callers catch it without coupling to the
 * serializer; the exception code is the HTTP status the error handler renders.
 */
interface SerializerExceptionInterface extends Throwable {}
