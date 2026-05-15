<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Cache;

/**
 * Cache-subsystem constants (Phase 4 / RFC-013).
 */
final class Constant
{
    /** Default TTL when callers omit one (seconds). 1 hour. */
    public const int DEFAULT_TTL = 3_600;

    /**
     * PSR-16 §1.3 reserved characters in cache keys. Implementations MUST
     * reject keys containing any of these.
     */
    public const string RESERVED_CHARACTERS = '{}()/\\@:';

    /** PSR-16 §1.3 maximum supported key length. */
    public const int MAX_KEY_LENGTH = 64;

    /** Canonical XFetch beta default — see StampedeProtectionInterface. */
    public const float DEFAULT_BETA = 1.0;

    // Adapter identifiers used by CacheBackendUnavailableExceptionInterface::getBackend().
    public const string BACKEND_ARRAY = 'array';
    public const string BACKEND_FILE = 'file';
    public const string BACKEND_REDIS = 'redis';
}
