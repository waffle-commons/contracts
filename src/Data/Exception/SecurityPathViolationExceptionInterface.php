<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Data\Exception;

/**
 * Raised when a document-store operation targets a path outside the mandated
 * isolation boundaries (RFC-022 §4.2, Firestore Rule 1): a root-level
 * collection, a traversal attempt, or any path not produced by the strict
 * public/private scope factory.
 *
 * Extends {@see DatabaseExceptionInterface} so it flows through the unified
 * persistence-failure strategy (RFC-022 §7.3) like any other driver error.
 */
interface SecurityPathViolationExceptionInterface extends DatabaseExceptionInterface {}
