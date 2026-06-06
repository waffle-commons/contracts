<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Data\Enum;

use PHPUnit\Framework\Attributes\CoversClass;
use Waffle\Commons\Contracts\Data\Enum\Direction;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(Direction::class)]
final class DirectionTest extends AbstractTestCase
{
    public function testBackingValuesAreCanonicalSqlKeywords(): void
    {
        static::assertSame('ASC', Direction::Ascending->value);
        static::assertSame('DESC', Direction::Descending->value);
    }
}
