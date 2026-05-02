<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Validation;

interface ViolationInterface
{
    public function getMessage(): string;

    public function getPropertyPath(): string;

    public function getInvalidValue(): mixed;
}
