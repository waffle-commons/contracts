<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Csrf\Exception;

use Waffle\Commons\Contracts\Security\Exception\SecurityExceptionInterface;

/**
 * Marker for any failure raised by the CSRF subsystem.
 *
 * Extends `SecurityExceptionInterface` so the existing ABAC error-handling
 * pipeline (and the JsonErrorRenderer's `getCode() >= 400 < 600` heuristic
 * with explicit code 403) routes CSRF failures consistently with other
 * security denials.
 */
interface CsrfExceptionInterface extends SecurityExceptionInterface {}
