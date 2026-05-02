<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Service;

/**
 * Interface for services keeping a state during a request
 * and must be reset before the next request (Pattern Worker).
 */
interface ResettableInterface
{
    /**
     * Reset the service to its original state
     */
    public function reset(): void;
}
