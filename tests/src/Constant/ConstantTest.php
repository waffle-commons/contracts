<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Constant;

use Waffle\Commons\Contracts\Constant\Constant;
use WaffleTests\Commons\Contracts\AbstractTestCase;

final class ConstantTest extends AbstractTestCase
{
    public function testEnvironmentDefaultsToProd(): void
    {
        self::assertSame(Constant::ENV_PROD, Constant::ENV_DEFAULT);
    }

    public function testFailsafeDefaultsToDisabled(): void
    {
        self::assertSame(Constant::DISABLED, Constant::FAILSAFE_DEFAULT);
    }

    public function testAttributePrefixingIsConsistent(): void
    {
        self::assertSame('_' . Constant::CLASSNAME, Constant::ATTR_CLASSNAME);
        self::assertSame('_' . Constant::CONTROLLER, Constant::ATTR_CONTROLLER);
        self::assertSame('_' . Constant::METHOD, Constant::ATTR_METHOD);
    }
}
