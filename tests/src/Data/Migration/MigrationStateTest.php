<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Data\Migration;

use PHPUnit\Framework\Attributes\CoversClass;
use Waffle\Commons\Contracts\Data\Migration\Enum\MigrationStatus;
use Waffle\Commons\Contracts\Data\Migration\MigrationState;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(MigrationState::class)]
final class MigrationStateTest extends AbstractTestCase
{
    public function testAPendingVersionHasNoApplicationInstant(): void
    {
        $state = new MigrationState('20261021090000_create_users', MigrationStatus::Pending, reversible: true);

        static::assertSame('20261021090000_create_users', $state->version);
        static::assertSame(MigrationStatus::Pending, $state->status);
        static::assertTrue($state->reversible);
        static::assertNull($state->appliedAt);
    }

    public function testAnAppliedVersionKeepsTheLedgerInstantAsTheDriverReturnsIt(): void
    {
        $state = new MigrationState('001_init', MigrationStatus::Applied, false, '2026-10-21 09:00:00');

        static::assertFalse($state->reversible);
        static::assertSame('2026-10-21 09:00:00', $state->appliedAt);
    }

    public function testTheStatusValuesAreTheReportVocabulary(): void
    {
        static::assertSame('applied', MigrationStatus::Applied->value);
        static::assertSame('pending', MigrationStatus::Pending->value);
        static::assertSame('missing', MigrationStatus::Missing->value);
    }
}
