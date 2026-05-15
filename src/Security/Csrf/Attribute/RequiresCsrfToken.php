<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Csrf\Attribute;

use Attribute;

/**
 * Opt-in marker on a controller method declaring that the request MUST carry
 * a valid CSRF token. Mirrors the `#[Voter]` / `#[Dto]` pattern.
 *
 * The CSRF middleware reads this attribute, looks up the active token under
 * `$id`, and rejects the request with HTTP 403 if validation fails.
 *
 * Example:
 * ```
 * #[Route('/account/delete', methods: ['POST'])]
 * #[RequiresCsrfToken(id: 'form:account-delete')]
 * public function deleteAccount(): ResponseInterface { ... }
 * ```
 */
#[Attribute(Attribute::TARGET_METHOD)]
final readonly class RequiresCsrfToken
{
    /**
     * @param string $id The CSRF token bucket required for this method.
     *                   Defaults to "_default" — appropriate for most cases
     *                   but distinct ids let multiple sensitive forms on the
     *                   same page rotate independently.
     */
    public function __construct(
        public string $id = '_default',
    ) {}
}
