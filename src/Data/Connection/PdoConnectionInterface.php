<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Connection;

use PDO;

/**
 * A relational connection lease exposing its underlying {@see PDO} handle.
 *
 * This is the single escape hatch that lets relational repositories keep fully
 * typed PDO access (`prepare`, `beginTransaction`, `bindValue`, …) while the
 * generic {@see ConnectionPoolInterface} stays backend-neutral. The `PDO` import
 * is deliberately confined to this one relational file — it is a PHP-core type,
 * never a sibling-component dependency, so the contracts perimeter is preserved.
 */
interface PdoConnectionInterface extends ConnectionInterface
{
    /**
     * The live, exception-error-mode {@see PDO} handle backing this lease.
     */
    public function pdo(): PDO;
}
