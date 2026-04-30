<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Validation;

interface ValidationResultInterface
{
    public function isValid(): bool;

    public function getViolations(): array;
}