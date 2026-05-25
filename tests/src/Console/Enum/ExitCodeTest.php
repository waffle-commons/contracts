<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Console\Enum;

use Waffle\Commons\Contracts\Console\Enum\ExitCode;
use WaffleTests\Commons\Contracts\AbstractTestCase;

final class ExitCodeTest extends AbstractTestCase
{
    public function testSuccessIsTheOnlySuccessfulCode(): void
    {
        static::assertTrue(ExitCode::SUCCESS->isSuccess());
        static::assertFalse(ExitCode::SUCCESS->isFailure());
    }

    public function testNonZeroCodesAreFailures(): void
    {
        static::assertFalse(ExitCode::FAILURE->isSuccess());
        static::assertTrue(ExitCode::FAILURE->isFailure());
        static::assertTrue(ExitCode::CONFIG->isFailure());
    }

    public function testRawValuesFollowSysexits(): void
    {
        static::assertSame(0, ExitCode::SUCCESS->value);
        static::assertSame(64, ExitCode::USAGE->value);
        static::assertSame(78, ExitCode::CONFIG->value);
    }
}
