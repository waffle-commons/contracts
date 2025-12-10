<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Exception;

interface SecurityExceptionInterface
{
    /**
     * @return array<string, mixed>
     */
    public function serialize(): array;
}
