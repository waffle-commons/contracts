<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Queue;

/**
 * A background job ([QUEUE-01]): a strictly typed DTO that a queue carries as
 * JSON from the process that dispatches it to the worker that handles it.
 *
 * A message holds data only — scalars, backed enums, nested DTOs and lists of
 * them — never a closure, a resource or a service. A consumer rebuilds it, in
 * another process, through its constructor, so its validation runs again; it
 * rebuilds only the message classes it allows, and never with `unserialize()`:
 * a queue is an input channel.
 *
 * Delivery is at least once. A handler must be idempotent, or de-duplicate on
 * the envelope id ({@see Envelope::$id}).
 */
interface MessageInterface {}
