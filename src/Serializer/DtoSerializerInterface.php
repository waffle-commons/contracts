<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Serializer;

use Waffle\Commons\Contracts\Serializer\Exception\SerializerExceptionInterface;

/**
 * Turns JSON into `#[Dto]` objects and `#[Dto]` objects into JSON at the HTTP
 * boundary (API-02), so the framework and the other components use the
 * serializer without importing it: the controller argument resolver hydrates
 * request bodies with it, the response converter writes returned DTOs with it,
 * and a queue driver encodes its messages with it.
 *
 * A DTO is always built through its constructor, so its `set` hooks validate
 * every value. Data that does not fit the DTO is a validation failure
 * (`ValidationExceptionInterface`, rendered as a 422) that names the field.
 */
interface DtoSerializerInterface
{
    /**
     * Whether `$class` is a `#[Dto]` this serializer handles.
     *
     * @throws SerializerExceptionInterface When `$class` is a `#[Dto]` whose shape the serializer cannot represent.
     */
    public function supports(string $class): bool;

    /**
     * Builds a DTO from a decoded JSON object.
     *
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return T
     *
     * @throws SerializerExceptionInterface When the data does not fit the DTO, or the class is not one it handles.
     */
    public function denormalize(array $data, string $class): object;

    /**
     * Builds a DTO from a JSON document, decoded within the serializer's size and
     * depth limits.
     *
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return T
     *
     * @throws SerializerExceptionInterface When the document is too large, is not a JSON object, or does not fit
     *                                      the DTO.
     */
    public function deserialize(string $json, string $class): object;

    /**
     * Writes a DTO as a JSON object.
     *
     * @throws SerializerExceptionInterface When the object is not a DTO it handles.
     */
    public function serialize(object $dto): string;
}
