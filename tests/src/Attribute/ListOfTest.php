<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\Attribute;

use Attribute;
use ReflectionClass;
use ReflectionProperty;
use Waffle\Commons\Contracts\Attribute\ListOf;
use WaffleTests\Commons\Contracts\AbstractTestCase;

/**
 * Tests for the #[ListOf] element-type attribute in contracts.
 */
final class ListOfTest extends AbstractTestCase
{
    public function testConstructorExposesTheElementType(): void
    {
        static::assertSame('string', new ListOf('string')->type);
        static::assertSame(self::class, new ListOf(self::class)->type);
    }

    public function testTargetsParametersAndProperties(): void
    {
        $attribute = new ReflectionClass(ListOf::class)->getAttributes(Attribute::class)[0] ?? null;

        static::assertNotNull($attribute);
        static::assertSame(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY, $attribute->newInstance()->flags);
    }

    public function testAPromotedParameterCarriesItOnTheParameterAndTheProperty(): void
    {
        $dto = new class(['a', 'b']) {
            /**
             * @param list<string> $tags
             */
            public function __construct(
                #[ListOf('string')]
                public array $tags,
            ) {}
        };

        $constructor = new ReflectionClass($dto)->getConstructor();
        static::assertNotNull($constructor);

        foreach ($constructor->getParameters() as $parameter) {
            $onParameter = $parameter->getAttributes(ListOf::class)[0] ?? null;
            static::assertNotNull($onParameter);
            static::assertSame('string', $onParameter->newInstance()->type);
        }

        $onProperty = new ReflectionProperty($dto, 'tags')->getAttributes(ListOf::class)[0] ?? null;
        static::assertNotNull($onProperty);
        static::assertSame('string', $onProperty->newInstance()->type);
        static::assertSame(['a', 'b'], $dto->tags);
    }
}
