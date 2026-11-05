<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\OpenApi\Attribute;

use Attribute;

/**
 * Describes one DTO field in the schemas `openapi:generate` writes (RFC-016,
 * API-01).
 *
 * The DTO shape reader gives each field its type, whether a request must send it
 * and its default; this attribute adds a description and an example. Put it on a
 * constructor parameter for what a request sends and on a property for what a
 * response carries. On a promoted parameter it applies to both.
 *
 * ```php
 * use Waffle\Commons\Contracts\OpenApi\Attribute as OA;
 *
 * #[Dto]
 * final readonly class UserView
 * {
 *     public function __construct(
 *         #[OA\Property(description: 'Public identifier.', example: 42)]
 *         public int $id,
 *     ) {}
 * }
 * ```
 */
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
final readonly class Property
{
    /**
     * @param string|null                $description What the field holds.
     * @param string|int|float|bool|null $example     A sample value, written as the schema's `examples`.
     */
    public function __construct(
        public ?string $description = null,
        public string|int|float|bool|null $example = null,
    ) {}
}
