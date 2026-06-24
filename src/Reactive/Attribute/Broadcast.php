<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Reactive\Attribute;

use Attribute;

/**
 * Marks a mutable DTO/Entity property whose changes are broadcast in real time
 * (REACTIVE-01).
 *
 * A property carrying this attribute uses a PHP 8.5 `set` write-hook to enqueue a
 * {@see \Waffle\Commons\Contracts\Reactive\MutationRecord} into the request-scoped
 * broadcast buffer — performing NO I/O in the hook itself. A finish-request
 * listener drains the buffer and pushes the serialized mutations over the
 * configured transport (SSE / Mercure) after the response cycle.
 *
 * Because hooked properties cannot be `readonly` in PHP 8.5, this attribute
 * applies only to mutable-state DTOs (`final class` + `public private(set)`),
 * never to `final readonly` value objects.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final readonly class Broadcast
{
    /**
     * @param string $channel Logical channel the mutation is published on
     *                        (e.g. `orders`, `user.42`).
     */
    public function __construct(
        public string $channel,
    ) {}
}
