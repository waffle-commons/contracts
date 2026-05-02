<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Validation;

interface ValidatorInterface
{
    public function validate(object $value, array $groups = []): ValidationResultInterface;
}
