<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Handler;

use Psr\Http\Message\ResponseInterface;

interface ResponseConverterInterface
{
    /**
     * Converts a controller return value to a PSR-7 Response.
     *
     * @param mixed $result The value returned by the controller.
     * @return ResponseInterface The converted HTTP response.
     * @throws \RuntimeException If the result cannot be converted.
     */
    public function convert(mixed $result): ResponseInterface;
}
