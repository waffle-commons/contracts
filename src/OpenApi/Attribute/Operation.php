<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\OpenApi\Attribute;

use Attribute;

/**
 * Describes the operations `openapi:generate` writes for a route (RFC-016, API-01).
 *
 * The generator already documents each operation's parameters, body and responses
 * from the route and the typed signature; this attribute adds what a signature
 * cannot say. On a controller method it describes that method's operations. On a
 * controller class it gives defaults to every route of the class, typically their
 * tags: a summary or description set on the method wins, the method's tags replace
 * the class's when it has any, and either level can mark an operation deprecated.
 *
 * ```php
 * use Waffle\Commons\Contracts\OpenApi\Attribute as OA;
 *
 * #[OA\Operation(tags: ['users'])]
 * final class UserController
 * {
 *     #[Route('/users/{id}')]
 *     #[OA\Operation(summary: 'Fetch a user', description: 'Answers 404 when no user has this id.')]
 *     public function show(int $id): UserView { ... }
 * }
 * ```
 *
 * Without it the document is still valid, only terse.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final readonly class Operation
{
    /**
     * @param string|null  $summary     One line, shown next to the path.
     * @param string|null  $description Longer text; CommonMark is allowed.
     * @param list<string> $tags        The groups the operation is listed under.
     * @param bool         $deprecated  Whether clients should stop calling the operation.
     */
    public function __construct(
        public ?string $summary = null,
        public ?string $description = null,
        public array $tags = [],
        public bool $deprecated = false,
    ) {}
}
