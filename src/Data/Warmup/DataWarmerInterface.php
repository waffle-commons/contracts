<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Warmup;

/**
 * Pre-compiles expensive artifacts — SQR trees, routing tables, … — into
 * PHP-returnable cache files and primes OPcache shared memory with them, so
 * the first live request after a deploy reads pre-compiled state instead of
 * paying the compilation and disk-I/O cost (Roadmap Beta-3 — "CLI Route &
 * Cache Warmup").
 *
 * Implementations MUST be stateless and idempotent: warming is a CLI-side
 * operation (`waffle data:warmup`) that never runs during an HTTP request and
 * is safe to re-run after every deploy.
 */
interface DataWarmerInterface
{
    /**
     * Compiles and persists every artifact this warmer owns.
     *
     * @return list<string> Human-readable descriptors of the warmed artifacts
     *                      (e.g. `4 compiled SQR tree(s) → var/cache/data-warmup.php`).
     */
    public function warmUp(): array;
}
