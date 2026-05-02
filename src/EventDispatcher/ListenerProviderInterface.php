<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\EventDispatcher;

interface ListenerProviderInterface
{
    /**
     * Gets all listeners for the given event.
     *
     * @param object $event An event for which to return the matching listeners.
     * @return iterable<callable> The sequence of listeners to invoke for the event.
     */
    public function getListenersForEvent(object $event): iterable;
}
