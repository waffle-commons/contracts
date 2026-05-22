<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\HttpClient\Exception;

use Psr\Http\Client\ClientExceptionInterface as PsrClientExceptionInterface;
use Throwable;

/**
 * Marker for any failure raised by the Waffle HTTP Client subsystem.
 *
 * Extends `\Throwable` and `Psr\Http\Client\ClientExceptionInterface` so callers
 * may catch either the Waffle marker or the PSR-18 marker. Concrete exceptions
 * (`RequestExceptionInterface`, `NetworkExceptionInterface`) descend from this.
 */
interface HttpClientExceptionInterface extends Throwable, PsrClientExceptionInterface {}
