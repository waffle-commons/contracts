<?php

declare(strict_types=1);

namespace WaffleTests\Commons\Contracts\OpenApi\Attribute;

use Attribute;
use ReflectionClass;
use ReflectionProperty;
use Waffle\Commons\Contracts\OpenApi\Attribute\Operation;
use Waffle\Commons\Contracts\OpenApi\Attribute\Property;
use Waffle\Commons\Contracts\OpenApi\Attribute\Response;
use WaffleTests\Commons\Contracts\AbstractTestCase;

/**
 * Tests for the #[OA\Operation], #[OA\Response] and #[OA\Property] attributes in contracts (API-01).
 */
final class OpenApiAttributesTest extends AbstractTestCase
{
    public function testAnOperationDescribesNothingByDefault(): void
    {
        $operation = new Operation();

        static::assertNull($operation->summary);
        static::assertNull($operation->description);
        static::assertSame([], $operation->tags);
        static::assertFalse($operation->deprecated);
    }

    public function testAnOperationExposesWhatItIsGiven(): void
    {
        $operation = new Operation('Fetch a user', 'Answers 404 when no user has this id.', ['users'], true);

        static::assertSame('Fetch a user', $operation->summary);
        static::assertSame('Answers 404 when no user has this id.', $operation->description);
        static::assertSame(['users'], $operation->tags);
        static::assertTrue($operation->deprecated);
    }

    public function testAResponseHasNoBodyTypeByDefault(): void
    {
        $response = new Response(404, 'No user has this id.');

        static::assertSame(404, $response->status);
        static::assertSame('No user has this id.', $response->description);
        static::assertNull($response->type);
        static::assertSame(self::class, new Response(200, 'The user.', self::class)->type);
    }

    public function testAPropertyExposesItsDescriptionAndExample(): void
    {
        static::assertNull(new Property()->description);
        static::assertNull(new Property()->example);
        static::assertSame('Public identifier.', new Property('Public identifier.', 42)->description);
        static::assertSame(42, new Property(example: 42)->example);
        static::assertSame('2026-10-31', new Property(example: '2026-10-31')->example);
    }

    public function testEachAttributeTargetsWhatItDescribes(): void
    {
        static::assertSame(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD, self::flags(Operation::class));
        static::assertSame(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE, self::flags(Response::class));
        static::assertSame(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY, self::flags(Property::class));
    }

    public function testAPromotedParameterCarriesThePropertyOnBothSides(): void
    {
        $dto = new class(42) {
            public function __construct(
                #[Property(description: 'Public identifier.', example: 42)]
                public int $id,
            ) {}
        };

        $parameter = new ReflectionClass($dto)->getConstructor()?->getParameters()[0] ?? null;
        static::assertNotNull($parameter);
        $onParameter = $parameter->getAttributes(Property::class)[0] ?? null;
        $onProperty = new ReflectionProperty($dto, 'id')->getAttributes(Property::class)[0] ?? null;

        static::assertNotNull($onParameter);
        static::assertNotNull($onProperty);
        static::assertSame('Public identifier.', $onParameter->newInstance()->description);
        static::assertSame(42, $onProperty->newInstance()->example);
    }

    /**
     * @param class-string $class
     */
    private static function flags(string $class): int
    {
        $attribute = new ReflectionClass($class)->getAttributes(Attribute::class)[0] ?? null;
        static::assertNotNull($attribute);

        return $attribute->newInstance()->flags;
    }
}
