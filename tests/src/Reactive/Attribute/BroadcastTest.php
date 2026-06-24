<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Reactive\Attribute;

use Attribute;
use ReflectionClass;
use Waffle\Commons\Contracts\Reactive\Attribute\Broadcast;
use WaffleTests\Commons\Contracts\AbstractTestCase;

/**
 * Tests for the #[Broadcast] property attribute in contracts.
 */
final class BroadcastTest extends AbstractTestCase
{
    public function testConstructorExposesTheChannel(): void
    {
        $broadcast = new Broadcast('orders');

        static::assertSame('orders', $broadcast->channel);
    }

    public function testTargetsPropertiesOnly(): void
    {
        $reflection = new ReflectionClass(Broadcast::class);
        $attributes = $reflection->getAttributes(Attribute::class);

        static::assertCount(1, $attributes);
        $attribute = $attributes[0] ?? null;
        static::assertNotNull($attribute);
        static::assertSame(Attribute::TARGET_PROPERTY, $attribute->newInstance()->flags);
    }
}
