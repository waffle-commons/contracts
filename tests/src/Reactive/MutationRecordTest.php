<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Reactive;

use Waffle\Commons\Contracts\Reactive\MutationRecord;
use WaffleTests\Commons\Contracts\AbstractTestCase;

/**
 * Tests for the MutationRecord value object in contracts.
 */
final class MutationRecordTest extends AbstractTestCase
{
    public function testConstructorExposesEveryField(): void
    {
        $record = new MutationRecord('orders', 'App\\Order', 'status', 'paid');

        static::assertSame('orders', $record->channel);
        static::assertSame('App\\Order', $record->entityClass);
        static::assertSame('status', $record->property);
        static::assertSame('paid', $record->value);
    }

    public function testValueAcceptsAnyShape(): void
    {
        // `value` is `mixed` — it carries whatever the broadcast property held.
        static::assertSame(42, new MutationRecord('c', 'App\\E', 'count', 42)->value);
        static::assertSame(['a', 'b'], new MutationRecord('c', 'App\\E', 'tags', ['a', 'b'])->value);
        static::assertNull(new MutationRecord('c', 'App\\E', 'cleared', null)->value);
    }
}
