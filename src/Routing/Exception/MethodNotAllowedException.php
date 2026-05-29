<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Routing\Exception;

use RuntimeException;
use Throwable;

/**
 * Concrete exception thrown when an HTTP method is not allowed.
 */
final class MethodNotAllowedException extends RuntimeException implements MethodNotAllowedExceptionInterface
{
    /**
     * @param list<string> $allowedMethods List of allowed HTTP methods.
     * @param string $message Error message.
     * @param int $code HTTP status code (405).
     * @param Throwable|null $previous Previous exception.
     */
    public function __construct(
        private readonly array $allowedMethods,
        string $message = 'The requested HTTP method is not allowed.',
        int $code = 405,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return list<string>
     */
    #[\Override]
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }
}
