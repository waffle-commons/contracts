<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Exception;

use Throwable;

interface SecurityExceptionInterface extends Throwable
{
    /**
     * @return array<string, mixed>
     */
    public function serialize(): array;
}
