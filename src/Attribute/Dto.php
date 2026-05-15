<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Attribute;

use Attribute;

/**
 * Marker attribute identifying a class as an auto-hydrated Data Transfer Object.
 *
 * Per RFC-011 (Alpha 6 P1) the framework's ControllerArgumentResolver detects this
 * attribute on a controller parameter's type, decodes the PSR-7 parsed body, and
 * hydrates the DTO via its constructor. PHP 8.5 Property Hooks inside the DTO are
 * responsible for validation — the resolver itself remains free of validation logic.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final readonly class Dto {}
