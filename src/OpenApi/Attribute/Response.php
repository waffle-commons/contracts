<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\OpenApi\Attribute;

use Attribute;

/**
 * Documents one response of an operation that `openapi:generate` writes
 * (RFC-016, API-01). Repeatable: one attribute per status.
 *
 * The generator documents the responses the signature implies: 200 with the
 * returned DTO, and 204 for `void` or a nullable return. For one of those statuses
 * the attribute replaces the description and, given a type, the body. Any other
 * status, such as one the controller answers by throwing, is added.
 *
 * ```php
 * use Waffle\Commons\Contracts\OpenApi\Attribute as OA;
 *
 * #[Route('/users/{id}')]
 * #[OA\Response(200, 'The user.')]
 * #[OA\Response(404, 'No user has this id.')]
 * public function show(int $id): UserView { ... }
 * ```
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final readonly class Response
{
    /**
     * @param int               $status      An HTTP status code, from 100 to 599.
     * @param string            $description What the response means; OpenAPI requires one.
     * @param class-string|null $type        The `#[Dto]` class of a JSON body, or null for none.
     */
    public function __construct(
        public int $status,
        public string $description,
        public ?string $type = null,
    ) {}
}
