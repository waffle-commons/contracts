<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Routing\Exception;

/**
 * Marker interface for routing's "no match" condition. Extends `\Throwable` so
 * the interface itself is a valid catch target and so mago's analyzer can
 * resolve it via the `no-valid-catch-type-found` rule.
 */
interface RouteNotFoundExceptionInterface extends \Throwable {}
