<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Validation;

use Waffle\Commons\Contracts\Exception\Validation\ValidationExceptionInterface;

/**
 * Opt-in contract for a value object that can re-run its own validation on
 * demand.
 *
 * Waffle DTOs already validate at construction through Property Hooks, but a
 * service that wants to validate through an injectable, mockable
 * {@see ValidatorInterface} — rather than calling the static `Assert` facade
 * directly — needs something the validator can invoke. An object implementing
 * this expresses its rules with the framework's assertion helpers and MUST
 * throw a {@see ValidationExceptionInterface} on the first failing constraint.
 */
interface SelfValidatingInterface
{
    /**
     * @throws ValidationExceptionInterface On the first failing constraint.
     */
    public function assertValid(): void;
}
