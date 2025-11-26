<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Http;

use Psr\Http\Message\ResponseInterface;

interface ResponseEmitterInterface
{
    public function emit(ResponseInterface $response): void;
}
