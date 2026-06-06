<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Data\Enum;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Waffle\Commons\Contracts\Data\Enum\Operator;
use WaffleTests\Commons\Contracts\AbstractTestCase;

#[CoversClass(Operator::class)]
final class OperatorTest extends AbstractTestCase
{
    public function testBackingValuesAreCanonicalSqlTokens(): void
    {
        static::assertSame('=', Operator::Equal->value);
        static::assertSame('<>', Operator::NotEqual->value);
        static::assertSame('NOT IN', Operator::NotIn->value);
        static::assertSame('LIKE', Operator::Like->value);
    }

    /**
     * @return iterable<string, array{Operator, bool}>
     */
    public static function operatorProvider(): iterable
    {
        yield 'IN is a set operator' => [Operator::In, true];
        yield 'NOT IN is a set operator' => [Operator::NotIn, true];
        yield 'equal is scalar' => [Operator::Equal, false];
        yield 'greater-than is scalar' => [Operator::GreaterThan, false];
        yield 'like is scalar' => [Operator::Like, false];
    }

    #[DataProvider('operatorProvider')]
    public function testIsSetOperator(Operator $operator, bool $expected): void
    {
        static::assertSame($expected, $operator->isSetOperator());
    }
}
