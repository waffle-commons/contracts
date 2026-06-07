<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Auth\Exception;

/**
 * Marker for OAuth2/OIDC flow failures (RFC-021 §4.5): unreachable or
 * malformed discovery documents, provider error responses at the token
 * endpoint, transaction (`state`/`nonce`/PKCE) violations, or userinfo
 * resolution failures.
 */
interface OauthExceptionInterface extends AuthExceptionInterface {}
