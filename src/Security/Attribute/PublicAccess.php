<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Attribute;

use Attribute;

/**
 * Marks a controller method as intentionally publicly accessible.
 *
 * Beta-1 introduces fail-closed ABAC: `SecureContainer::analyze()` rejects any
 * action whose target carries no `#[Voter]` rules. `#[PublicAccess]` is the
 * explicit escape hatch for endpoints that genuinely require no authorization
 * (health checks, login forms, public APIs). Forgetting it produces a 403 — the
 * absence of policy is treated as a missing decision, not an implicit allow.
 *
 * Method-only (SEC-05): every public action must carry its own `#[PublicAccess]`.
 * A prior revision also allowed class-level placement, exempting every unvoted
 * method in the controller — including any added later without the author
 * revisiting the class's exposure. Method-level is now the only valid
 * placement: under the project's Mago gate, `Attribute::TARGET_METHOD` makes a
 * stray class-level placement a hard STATIC ANALYSIS ERROR
 * (`invalid-attribute-target`), caught before the code ever ships. Only a
 * hypothetical un-gated consumer could compile such a placement — and even
 * there it would merely be inert at runtime, because PHP validates an
 * attribute's target only when `ReflectionAttribute::newInstance()` is called
 * and `SecureContainer` never reads class-level attributes of this type. The
 * runtime safety net is unchanged either way: an action with no `#[Voter]` and
 * no method-level `#[PublicAccess]` still gets a 403 regardless of anything
 * declared on its class.
 */
#[Attribute(Attribute::TARGET_METHOD)]
final readonly class PublicAccess {}
