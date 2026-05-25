<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Security\Csrf\Attribute;

use Waffle\Commons\Contracts\Security\Csrf\Attribute\RequiresCsrfToken;
use WaffleTests\Commons\Contracts\AbstractTestCase;

final class RequiresCsrfTokenTest extends AbstractTestCase
{
    public function testDefaultsToTheSharedBucket(): void
    {
        $token = new RequiresCsrfToken();

        static::assertSame('_default', $token->id);
    }

    public function testCustomBucketIdIsExposed(): void
    {
        $token = new RequiresCsrfToken(id: 'form:account-delete');

        static::assertSame('form:account-delete', $token->id);
    }
}
