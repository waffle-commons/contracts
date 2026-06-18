<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Telemetry;

/**
 * No-op propagator: injects nothing and extracts nothing. The default when no
 * tracing SDK is bound, so the HTTP client emits no trace headers.
 */
final class NullTextMapPropagator implements TextMapPropagatorInterface
{
    /**
     * @param array<string, string> $carrier
     * @param-out array<string, string> $carrier
     */
    #[\Override]
    public function inject(SpanContextInterface $context, array &$carrier): void
    {
        // no-op: nothing to propagate.
    }

    /**
     * @param array<string, string> $carrier
     */
    #[\Override]
    public function extract(array $carrier): ?SpanContextInterface
    {
        return null;
    }
}
