<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Mailer;

use Waffle\Commons\Contracts\Mailer\Exception\MailerExceptionInterface;

/**
 * Sends transactional email ([QUEUE-03]) — a contract only: SMTP and API
 * transports are post-v1, and an application binds any mailer it chooses.
 *
 * Sending blocks on the network, so a request should not send: it dispatches the
 * {@see Email} (a queue message) and a worker hands it to the mailer.
 */
interface MailerInterface
{
    /**
     * Sends an email now.
     *
     * @throws MailerExceptionInterface When the transport refuses the email or cannot be reached.
     */
    public function send(Email $email): void;
}
