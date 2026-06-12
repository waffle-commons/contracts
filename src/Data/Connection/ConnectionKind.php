<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Connection;

/**
 * Category of a persistent connection reported to a {@see ConnectionTrackerInterface}.
 *
 * Used by the DIAG-03 orphaned-connection tracer to label a handle opened during
 * a request lifecycle (relational pool socket, Redis socket, or file/network
 * stream) so a still-open handle can be surfaced with a meaningful kind.
 */
enum ConnectionKind: string
{
    case Pdo = 'pdo';
    case Redis = 'redis';
    case Stream = 'stream';
}
