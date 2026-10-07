<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Attribute;

use Attribute;

/**
 * Declares the element type of a list-typed DTO member (RFC-016, API-01/API-02).
 *
 * PHP has no generics: a constructor parameter or a property declared `array`
 * says nothing about what it holds. `#[ListOf]` closes that gap for the DTOs that
 * cross the HTTP boundary. The build-time DTO-shape reader in
 * `waffle-commons/utils` reads it, the serializer checks and (de)normalizes every
 * element against it, and the OpenAPI generator emits it as the schema's `items`,
 * so the spec and the serializer agree on what the list holds.
 *
 * The element type is a builtin scalar name (`'int'`, `'float'`, `'string'`,
 * `'bool'`) or the class-string of a `#[Dto]` class or of a backed enum:
 *
 * ```php
 * #[Dto]
 * final readonly class OrderInput
 * {
 *     /**
 *      * @param list<OrderLine> $lines
 *      * @param list<string>    $tags
 *      *\/
 *     public function __construct(
 *         #[ListOf(OrderLine::class)] public array $lines,
 *         #[ListOf('string')] public array $tags = [],
 *     ) {}
 * }
 * ```
 *
 * On a promoted constructor parameter the attribute applies to both the
 * parameter and the property. It describes one level: a list of lists is not
 * supported. Keep the `list<…>` docblock as well — Mago reads the docblock, the
 * reader reads the attribute.
 */
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
final readonly class ListOf
{
    /**
     * @param 'int'|'float'|'string'|'bool'|class-string $type The element type.
     */
    public function __construct(
        public string $type,
    ) {}
}
