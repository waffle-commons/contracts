<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Auth;

use Waffle\Commons\Contracts\Auth\Constant;
use WaffleTests\Commons\Contracts\AbstractTestCase;

final class ConstantTest extends AbstractTestCase
{
    public function testAssertionTransportLocationsAreStable(): void
    {
        self::assertSame('X-Wfl-Assert-User', Constant::ASSERTION_HEADER);
        self::assertSame('WAFFLE_AUTH_SECRET', Constant::SECRET_ENV_KEY);
        self::assertSame('_auth_identity', Constant::REQUEST_ATTRIBUTE);
    }

    public function testCryptographicFloorsMatchRfc021Mandates(): void
    {
        // RFC-021 §4.3: strict 5-second anti-replay window.
        self::assertSame(5, Constant::ASSERTION_TTL);

        // RFC-021 §4.2: HMAC-SHA256 security floor — fail-closed below this.
        self::assertSame(32, Constant::MIN_SECRET_BYTES);
    }

    public function testAssertionClaimKeysMatchCompactWireFormat(): void
    {
        self::assertSame('usr', Constant::CLAIM_SUBJECT);
        self::assertSame('eml', Constant::CLAIM_EMAIL);
        self::assertSame('rol', Constant::CLAIM_ROLES);
        self::assertSame('ten', Constant::CLAIM_TENANT);
        self::assertSame('iat', Constant::CLAIM_ISSUED_AT);
        self::assertSame('exp', Constant::CLAIM_EXPIRES_AT);
        self::assertSame('iph', Constant::CLAIM_IP_HASH);
    }

    public function testAuthorizationSchemePrefixesIncludeSeparator(): void
    {
        self::assertSame('Authorization', Constant::AUTHORIZATION_HEADER);
        self::assertSame('Bearer ', Constant::BEARER_PREFIX);
        self::assertSame('Basic ', Constant::BASIC_PREFIX);
        self::assertSame('X-Api-Key', Constant::API_KEY_HEADER);
    }

    public function testOauthTransactionCookieIsShortLived(): void
    {
        self::assertSame('WAFFLE_OAUTH_TX', Constant::OAUTH_TRANSACTION_COOKIE);

        // RFC-021 §4.5: ≤ 10 minutes — bounded replay window by design.
        self::assertSame(600, Constant::OAUTH_TRANSACTION_TTL);
    }
}
