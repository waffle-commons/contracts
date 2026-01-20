<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Security;

/**
 * The VoterInterface defines the mandatory contract for all security voters
 * and hierarchy levels in the Waffle ecosystem.
 */
interface VoterInterface
{
    /**
     * Decides whether the security requirement is met.
     * This method is called by the SecureContainer during the audit phase.
     * In future versions (Alpha 6), this will likely accept a SecurityContext
     * to check identity and roles.
     *
     * @return bool True if access is granted, false otherwise.
     */
    public function decide(): bool;
}
