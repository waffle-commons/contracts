<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Routing\Exception;

use Waffle\Commons\Contracts\Exception\WaffleExceptionInterface;

/**
 * Interface for exceptions thrown when an HTTP method is not allowed for a route.
 */
interface MethodNotAllowedExceptionInterface extends WaffleExceptionInterface
{
    /**
     * Returns the list of allowed HTTP methods for the route.
     *
     * @return list<string>
     */
    public function getAllowedMethods(): array;
}
