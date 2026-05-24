<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Console\Enum;

use Waffle\Commons\Contracts\Console\Enum\Verbosity;
use WaffleTests\Commons\Contracts\AbstractTestCase;

final class VerbosityTest extends AbstractTestCase
{
    public function testEqualOrHigherVerbosityPermitsTheMessage(): void
    {
        static::assertTrue(Verbosity::NORMAL->permits(Verbosity::NORMAL));
        static::assertTrue(Verbosity::DEBUG->permits(Verbosity::VERBOSE));
        static::assertTrue(Verbosity::VERBOSE->permits(Verbosity::QUIET));
    }

    public function testLowerVerbositySuppressesTheMessage(): void
    {
        static::assertFalse(Verbosity::QUIET->permits(Verbosity::NORMAL));
        static::assertFalse(Verbosity::NORMAL->permits(Verbosity::DEBUG));
    }
}
