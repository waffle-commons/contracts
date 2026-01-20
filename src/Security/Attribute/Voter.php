<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Attribute;

use Attribute;

/**
 * The Voter attribute is a security trigger used on controllers and methods.
 * It declares a security requirement that must be resolved by the SecureContainer.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final readonly class Voter
{
    /**
     * @param string $name The name of the voter class (e.g. App\Voter\MyCustomVoter::class).
     */
    public function __construct(
        public string $name,
    ) {}
}
