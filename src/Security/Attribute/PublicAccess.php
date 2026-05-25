<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security\Attribute;

use Attribute;

/**
 * Marks a controller class or method as intentionally publicly accessible.
 *
 * Beta-1 introduces fail-closed ABAC: `SecureContainer::analyze()` rejects any
 * action whose target carries no `#[Voter]` rules. `#[PublicAccess]` is the
 * explicit escape hatch for endpoints that genuinely require no authorization
 * (health checks, login forms, public APIs). Forgetting it produces a 403 — the
 * absence of policy is treated as a missing decision, not an implicit allow.
 *
 * Placement:
 * - On a class: every action in the controller is public unless an action also
 *   carries a `#[Voter]`. A method-level `#[Voter]` overrides the class default.
 * - On a method: only that action is public; sibling actions still require
 *   voters.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final readonly class PublicAccess {}
