<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Exception\Validation;

use Throwable;

/**
 * Marker interface for validation failures (RFC-011, Alpha 6 P1).
 *
 * Thrown when a DTO's Property Hook rejects an incoming value or when the
 * ControllerArgumentResolver cannot hydrate a `#[Dto]`-marked parameter
 * (missing required key, non-array body, etc.).
 *
 * The framework's JsonErrorRenderer recognises this marker and emits an
 * RFC 7807 HTTP 422 Unprocessable Entity response.
 */
interface ValidationExceptionInterface extends Throwable
{
    /**
     * Returns the offending property name, or null if the failure is not
     * tied to a single field (e.g. malformed JSON body).
     */
    public function getField(): ?string;
}
